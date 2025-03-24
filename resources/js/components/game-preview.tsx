export default function GamePreview({ title, players, moves }: {title: string, players: string, moves: string}) {
    return (
      <div className="border rounded-lg p-3 hover:shadow-md transition cursor-pointer">
        <h3 className="font-bold text-chess-blue">{title}</h3>
        <p className="text-sm text-gray-600 mb-2">{players}</p>
        <div className="bg-gray-100 p-2 rounded text-xs font-mono">
          {moves}
        </div>
      </div>
    )
  }