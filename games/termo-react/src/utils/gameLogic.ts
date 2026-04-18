import { WORDS } from './wordList'
import type { LetterState } from '../types'

export function getDailyWord(): string {
  const start = new Date(new Date().getFullYear(), 0, 0)
  const diff = +new Date() - +start
  const dayOfYear = Math.floor(diff / (1000 * 60 * 60 * 24))
  return WORDS[dayOfYear % WORDS.length]
}

export function validateGuess(guess: string, target: string): LetterState[] {
  const result: LetterState[] = Array(5).fill('absent')
  const targetArr = target.split('')
  const guessArr = guess.split('')

  guessArr.forEach((letter, i) => {
    if (letter === targetArr[i]) {
      result[i] = 'correct'
      targetArr[i] = ''
    }
  })

  guessArr.forEach((letter, i) => {
    if (result[i] !== 'correct') {
      const idx = targetArr.indexOf(letter)
      if (idx !== -1) {
        result[i] = 'present'
        targetArr[idx] = ''
      }
    }
  })

  return result
}

const STORAGE_KEY = 'techdle_stats'

export function loadStats() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    return raw ? JSON.parse(raw) : { wins: 0, losses: 0, streak: 0, lastPlayed: '', lastResult: null }
  } catch {
    return { wins: 0, losses: 0, streak: 0, lastPlayed: '', lastResult: null }
  }
}

export function saveStats(stats: object) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(stats))
}
