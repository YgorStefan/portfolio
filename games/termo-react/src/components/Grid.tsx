import type { GuessRow, LetterState } from '../types'

const STATE_CLASSES: Record<LetterState, string> = {
  correct: 'bg-green-600 border-green-600 text-white',
  present: 'bg-yellow-500 border-yellow-500 text-white',
  absent:  'bg-gray-600 border-gray-600 text-white',
  empty:   'bg-transparent border-gray-600 text-white',
}

interface Props {
  rows: GuessRow[]
  currentRow: number
  currentLetters: string[]
}

export default function Grid({ rows, currentRow, currentLetters }: Props) {
  return (
    <div className="grid gap-1.5 mb-6">
      {rows.map((row, ri) => (
        <div key={ri} className="flex gap-1.5">
          {Array(5).fill(null).map((_, ci) => {
            const isCurrentRow = ri === currentRow
            const letter = isCurrentRow ? (currentLetters[ci] ?? '') : (row.letters[ci] ?? '')
            const state: LetterState = row.submitted ? row.states[ci] : 'empty'
            return (
              <div
                key={ci}
                className={`w-14 h-14 flex items-center justify-center border-2 text-xl font-bold uppercase transition-all duration-300 ${STATE_CLASSES[state]}`}
              >
                {letter}
              </div>
            )
          })}
        </div>
      ))}
    </div>
  )
}
