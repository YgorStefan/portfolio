export const TECHS = [
  { id: 'js',     label: 'JavaScript', emoji: '🟨', svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect width="32" height="32" fill="#f7df1e"/><path d="M20.3 24.5c.4.7.95 1.2 1.9 1.2.8 0 1.3-.4 1.3-1 0-.67-.52-1-1.4-1.4l-.48-.2c-1.4-.6-2.3-1.35-2.3-2.94 0-1.46 1.1-2.57 2.85-2.57 1.24 0 2.13.43 2.77 1.56l-1.52.97c-.33-.6-.7-.83-1.25-.83-.57 0-.93.36-.93.83 0 .58.36.82 1.2 1.18l.48.2c1.65.7 2.56 1.44 2.56 3.07 0 1.76-1.38 2.7-3.24 2.7-1.82 0-2.99-.87-3.56-2.0l1.62-.93zm-8.1.17c.3.52.57.96 1.22.96.63 0 1.0-.24 1.0-.93v-5.02h1.9v5.06c0 1.54-.9 2.24-2.22 2.24-1.2 0-1.88-.62-2.23-1.37l1.33-.94z" fill="#000"/></svg>` },
  { id: 'react',  label: 'React',      emoji: '⚛️' },
  { id: 'python', label: 'Python',     emoji: '🐍' },
  { id: 'vue',    label: 'Vue',        emoji: '💚' },
  { id: 'css',    label: 'CSS',        emoji: '🎨' },
  { id: 'docker', label: 'Docker',     emoji: '🐳' },
  { id: 'git',    label: 'Git',        emoji: '🔀' },
  { id: 'node',   label: 'Node.js',    emoji: '🟩', svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect width="32" height="32" rx="4" fill="#215732"/><path d="M16 4l10.4 6v12L16 28 5.6 22V10L16 4zm0 2.3L7.4 11v10l8.6 4.97L24.6 21V11L16 6.3zm0 3.3l6.2 3.58v7.16L16 23.9l-6.2-3.57V13.2L16 9.6zm0 2.3l-3.6 2.08v4.16L16 20.22l3.6-2.08v-4.16L16 11.9z" fill="#6cc24a"/></svg>` },
]

export function createDeck() {
  const deck = [...TECHS, ...TECHS]
    .map((tech, i) => ({ uid: i, ...tech, isFlipped: false, isMatched: false }))
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]]
  }
  return deck
}
