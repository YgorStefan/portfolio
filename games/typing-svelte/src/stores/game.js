import { writable, derived } from 'svelte/store'

export const enemies  = writable([])
export const lives    = writable(3)
export const score    = writable(0)
export const typed    = writable('')
export const gameOver = writable(false)

export const activeEnemy = derived(enemies, $enemies =>
  $enemies.find(e => !e.destroyed) ?? null
)
