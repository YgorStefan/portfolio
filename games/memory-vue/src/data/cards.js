export const TECHS = [
  { id: 'js',     label: 'JavaScript', img: '/games/memory-vue/icons/javascript.svg' },
  { id: 'react',  label: 'React',      emoji: '⚛️' },
  { id: 'python', label: 'Python',     emoji: '🐍' },
  { id: 'vue',    label: 'Vue',        emoji: '💚' },
  { id: 'css',    label: 'CSS',        emoji: '🎨' },
  { id: 'docker', label: 'Docker',     emoji: '🐳' },
  { id: 'git',    label: 'Git',        emoji: '🔀' },
  { id: 'node',   label: 'Node.js',    img: '/games/memory-vue/icons/nodejs.svg' },
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
