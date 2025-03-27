import Square from "./square";

export default function ChessBoard() {
    let squares = [];

    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
          const isLight = (row + col) % 2 === 0
          squares.push(
            <Square isLight={isLight} square={row*8+col} piece={0} /> 
          )
        }
      }
      
      return (
        <div>
          <div className={`w-200 h-200 grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}>
            {squares}
          </div>
        </div>
      )
}