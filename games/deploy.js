const path = require('path')
const fs = require('fs')

const ROOT = path.resolve(__dirname, '..')
const GAMES = ['memory-vue', 'termo-react', 'runner-vanilla', 'typing-svelte']

GAMES.forEach(game => {
  const src = path.join(__dirname, game, 'dist')
  const dest = path.join(ROOT, 'public', 'games', game)

  if (!fs.existsSync(src)) {
    console.error(`✗ dist não encontrado para ${game} - rode npm run build antes`)
    process.exit(1)
  }

  if (fs.existsSync(dest)) fs.rmSync(dest, { recursive: true })
  fs.cpSync(src, dest, { recursive: true })
  console.log(`✓ ${game} → public/games/${game}`)
})
