const W_NS = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';

function collectParagraphs(xmlDoc) {
    const paras = xmlDoc.getElementsByTagNameNS(W_NS, 'p');
    const result = [];
    for (const para of paras) {
        const tNodes = [...para.getElementsByTagNameNS(W_NS, 't')];
        const fullText = tNodes.map(n => n.textContent).join('');
        if (fullText.trim()) result.push({ fullText, tNodes });
    }
    return result;
}

function redistributeText({ tNodes }, translatedText) {
    if (!tNodes.length) return;
    const first = tNodes[0];
    if (/^\s|\s$/.test(translatedText)) {
        first.setAttributeNS('http://www.w3.org/XML/1998/namespace', 'xml:space', 'preserve');
    }
    first.textContent = translatedText;
    for (let i = 1; i < tNodes.length; i++) tNodes[i].textContent = '';
}

const dropzone         = document.getElementById('dropzone');
const fileInput        = document.getElementById('fileInput');
const statusArea       = document.getElementById('statusArea');
const statusText       = document.getElementById('statusText');
const statusPercent    = document.getElementById('statusPercent');
const progressBar      = document.getElementById('progressBar');
const resultArea       = document.getElementById('resultArea');
const downloadWordBtn  = document.getElementById('downloadWordBtn');
const downloadPdfBtn   = document.getElementById('downloadPdfBtn');
const resetBtn         = document.getElementById('resetBtn');
const docxRenderContainer = document.getElementById('docxRenderContainer');

let translatedDocxBlob = null;
let originalFileName   = '';

dropzone.addEventListener('click', () => fileInput.click());

dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-blue-500', 'bg-gray-700/30');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-blue-500', 'bg-gray-700/30');
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-blue-500', 'bg-gray-700/30');
    if (e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]);
});

fileInput.addEventListener('change', (e) => {
    if (e.target.files.length) handleFile(e.target.files[0]);
});

resetBtn.addEventListener('click', () => {
    resultArea.classList.add('opacity-0');
    setTimeout(() => {
        resultArea.classList.add('hidden');
        dropzone.classList.remove('hidden');
        statusArea.classList.add('hidden');
        fileInput.value = '';
        translatedDocxBlob = null;
        docxRenderContainer.innerHTML = '';
    }, 500);
});

downloadWordBtn.addEventListener('click', () => {
    if (!translatedDocxBlob) return;
    const url = URL.createObjectURL(translatedDocxBlob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `translated_${originalFileName}`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});

downloadPdfBtn.addEventListener('click', () => {
    if (!translatedDocxBlob) return;
    exportToPDF(translatedDocxBlob);
});

function updateProgress(percent, text) {
    progressBar.style.width = `${percent}%`;
    statusPercent.textContent = `${percent}%`;
    statusText.textContent = text;
}

async function handleFile(file) {
    const ext = file.name.split('.').pop().toLowerCase();
    if (ext !== 'docx') {
        alert('Somente arquivos .docx são suportados. Converta seu arquivo para .docx antes de continuar.');
        return;
    }

    originalFileName = file.name;
    dropzone.classList.add('hidden');
    statusArea.classList.remove('hidden');

    try {
        updateProgress(5, 'Lendo arquivo...');
        translatedDocxBlob = await processDocx(file);
        updateProgress(100, 'Concluído!');
        setTimeout(() => {
            statusArea.classList.add('hidden');
            resultArea.classList.remove('hidden');
            void resultArea.offsetWidth;
            resultArea.classList.remove('opacity-0');
        }, 500);
    } catch (err) {
        alert('Erro no processamento: ' + err.message);
        dropzone.classList.remove('hidden');
        statusArea.classList.add('hidden');
    }
}

async function translateSingle(text) {
    const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=en&dt=t&q=${encodeURIComponent(text)}`;
    const res = await fetch(url);
    const json = await res.json();
    let result = '';
    if (json && json[0]) json[0].forEach(item => { if (item[0]) result += item[0]; });
    return result || text;
}

async function translateWithFallback(text) {
    if (encodeURIComponent(text).length <= 1800) {
        try { return await translateSingle(text); } catch { return text; }
    }
    const sentences = text.split('. ').filter(Boolean);
    const results = await Promise.all(
        sentences.map(s => translateSingle(s).catch(() => s))
    );
    return results.join('. ');
}

async function translateConcurrent(texts, onProgress) {
    const results = new Array(texts.length);
    const CHUNK = 3;
    for (let i = 0; i < texts.length; i += CHUNK) {
        const slice = texts.slice(i, i + CHUNK);
        const translated = await Promise.all(slice.map(t => translateWithFallback(t)));
        translated.forEach((r, j) => { results[i + j] = r; });
        onProgress(i + slice.length, texts.length);
    }
    return results;
}
