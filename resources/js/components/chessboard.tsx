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
          <div 
            key={`${row}-${col}`}
            className={`${isLight ? 'bg-green-200' : 'bg-green-600'} flex items-center justify-center`}
          >
            {/* we need to figure out what chess piece should be here, this could be done with a array we access or use the chess FEN notation or use bitboards */}
          </div>
        )
      }
    }
    
    return (
      <div className={`${sizeClasses[size]} grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}>
        {squares}
      </div>
    )
  }