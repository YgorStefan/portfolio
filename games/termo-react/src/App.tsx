import { useState, useEffect, useCallback } from 'react'
import Grid from './components/Grid'
import Keyboard from './components/Keyboard'
import type { GuessRow, LetterState, Stats } from './types'
import { getDailyWord, validateGuess, loadStats, saveStats } from './utils/gameLogic'

const MAX_ATTEMPTS = 6
const WORD_LENGTH = 5

function createEmptyRows(): GuessRow[] {
  return Array(MAX_ATTEMPTS).fill(null).map(() => ({
    letters: [],
    states: [],
    submitted: false,
  }))
}

export default function App() {
  const [target] = useState(getDailyWord)
  const [rows, setRows] = useState<GuessRow[]>(createEmptyRows)
  const [currentRow, setCurrentRow] = useState(0)
  const [currentLetters, setCurrentLetters] = useState<string[]>([])
  const [letterStates, setLetterStates] = useState<Record<string, LetterState>>({})
  const [status, setStatus] = useState<'playing' | 'won' | 'lost'>('playing')
  const [stats, setStats] = useState<Stats>(loadStats)
  const [message, setMessage] = useState('')

  function showMessage(msg: string) {
    setMessage(msg)
    setTimeout(() => setMessage(''), 2500)
  }

  function updateLetterStates(guess: string, states: LetterState[]) {
    setLetterStates(prev => {
      const next = { ...prev }
      const priority: LetterState[] = ['correct', 'present', 'absent']
      guess.split('').forEach((letter, i) => {
        const cur = next[letter]
        const newState = states[i]
        if (!cur || priority.indexOf(newState) < priority.indexOf(cur)) {
          next[letter] = newState
        }
      })
      return next
    })
  }

  const handleKey = useCallback((key: string) => {
    if (status !== 'playing') return

    if (key === '⌫' || key === 'Backspace') {
      setCurrentLetters(prev => prev.slice(0, -1))
      return
    }

    if (key === 'ENTER' || key === 'Enter') {
      if (currentLetters.length < WORD_LENGTH) {
        showMessage('Palavra incompleta')
        return
      }
      const guess = currentLetters.join('')
      const states = validateGuess(guess, target)

      setRows(prev => {
        const next = [...prev]
        next[currentRow] = { letters: currentLetters, states, submitted: true }
        return next
      })
      updateLetterStates(guess, states)
      setCurrentLetters([])

      if (guess === target) {
        const newStats: Stats = { ...stats, wins: stats.wins + 1, streak: stats.streak + 1, lastPlayed: new Date().toDateString(), lastResult: 'win' }
        setStats(newStats)
        saveStats(newStats)
        setStatus('won')
        showMessage('🎉 Você acertou!')
      } else if (currentRow + 1 >= MAX_ATTEMPTS) {
        const newStats: Stats = { ...stats, losses: stats.losses + 1, streak: 0, lastPlayed: new Date().toDateString(), lastResult: 'loss' }
        setStats(newStats)
        saveStats(newStats)
        setStatus('lost')
        showMessage(`A palavra era ${target}`)
      } else {
        setCurrentRow(r => r + 1)
      }
      return
    }

    if (/^[A-Za-z]$/.test(key) && currentLetters.length < WORD_LENGTH) {
      setCurrentLetters(prev => [...prev, key.toUpperCase()])
    }
  }, [status, currentLetters, currentRow, target, stats])

  useEffect(() => {
    const handler = (e: KeyboardEvent) => handleKey(e.key)
    window.addEventListener('keydown', handler)
    return () => window.removeEventListener('keydown', handler)
  }, [handleKey])

  return (
    <div className="min-h-screen bg-gray-900 text-white flex flex-col">
      <header className="flex items-center justify-between px-6 py-4 bg-gray-800 border-b border-gray-700">
        <a href="/" className="text-gray-400 hover:text-sky-400 text-sm">← Portfólio</a>
        <div className="flex flex-col items-center gap-2">
          <h1 className="text-xl font-bold">🟩 Techdle</h1>
          <div className="flex gap-2">
            {['React', 'TypeScript', 'Tailwind'].map(b => (
              <span key={b} className="text-xs font-semibold px-2 py-0.5 rounded-full border border-sky-400/40 bg-sky-400/10 text-sky-400">{b}</span>
            ))}
          </div>
        </div>
        <div className="text-sm text-gray-400">🏆 {stats.wins}V / {stats.losses}D</div>
      </header>

      <main className="flex flex-col items-center justify-center flex-1 px-4 py-6">
        {message && (
          <div className="mb-4 px-4 py-2 rounded bg-gray-700 text-white text-sm font-semibold">{message}</div>
        )}
        <Grid rows={rows} currentRow={currentRow} currentLetters={currentLetters} />
        <Keyboard letterStates={letterStates} onKey={handleKey} />
      </main>
    </div>
  )
}
