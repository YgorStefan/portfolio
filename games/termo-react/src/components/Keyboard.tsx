import type { LetterState } from '../types'

const ROWS = [
  ['Q','W','E','R','T','Y','U','I','O','P'],
  ['A','S','D','F','G','H','J','K','L'],
  ['ENTER','Z','X','C','V','B','N','M','⌫'],
]

const STATE_CLASSES: Record<LetterState, string> = {
  correct: 'bg-green-600 text-white',
  present: 'bg-yellow-500 text-white',
  absent:  'bg-gray-700 text-gray-400',
  empty:   'bg-gray-500 text-white',
}

interface Props {
  letterStates: Record<string, LetterState>
  onKey: (key: string) => void
}

export default function Keyboard({ letterStates, onKey }: Props) {
  return (
    <div className="flex flex-col items-center gap-1.5">
      {ROWS.map((row, i) => (
        <div key={i} className="flex gap-1">
          {row.map(key => {
            const state = letterStates[key] ?? 'empty'
            const isWide = key === 'ENTER' || key === '⌫'
            return (
              <button
                key={key}
                onClick={() => onKey(key)}
                className={`${isWide ? 'px-3' : 'w-9'} h-14 rounded font-bold text-sm transition-colors duration-200 ${STATE_CLASSES[state]}`}
              >
                {key}
              </button>
            )
          })}
        </div>
      ))}
    </div>
  )
}
