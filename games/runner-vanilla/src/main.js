import './style.css'
import { GameLoop } from './GameLoop.js'

const canvas = document.getElementById('game-canvas')
canvas.width = Math.min(window.innerWidth - 32, 800)
canvas.height = 200

let game = new GameLoop(canvas)
game.start()

function handleJump() {
  if (game.isGameOver) {
    game.stop()
    game = new GameLoop(canvas)
    game.start()
  } else {
    game.player.jump()
  }
}

document.addEventListener('keydown', e => {
  if (e.code === 'Space' || e.code === 'ArrowUp') {
    e.preventDefault()
    handleJump()
  }
})

canvas.addEventListener('click', handleJump)
canvas.addEventListener('touchstart', e => { e.preventDefault(); handleJump() })
