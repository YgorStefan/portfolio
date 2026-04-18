export type LetterState = 'correct' | 'present' | 'absent' | 'empty'

export interface GuessRow {
  letters: string[]
  states: LetterState[]
  submitted: boolean
}

export interface Stats {
  wins: number
  losses: number
  streak: number
  lastPlayed: string
  lastResult: 'win' | 'loss' | null
}
