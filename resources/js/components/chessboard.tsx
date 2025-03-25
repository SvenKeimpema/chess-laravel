import Square from "./square"

export default function ChessBoard({ size = 'medium' }: { size: 'small' | 'medium' | 'large' }) {
    const sizeClasses = {
      small: 'w-48 h-48',
      medium: 'w-64 h-64',
      large: 'w-96 h-96'
    }
    
    const squares = []
    
    for (let row = 0; row < 8; row++) {
      for (let col = 0; col < 8; col++) {
        const isLight = (row + col) % 2 === 0
        squares.push(
          <Square isLight={isLight} square={row*8+col} piece={0}>

          </Square>
        )
      }
    }
    
    return (
      <div>
        <div className={`${sizeClasses[size]} grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}>
          {squares}
        </div>
      </div>
    )
  }