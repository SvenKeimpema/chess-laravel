interface PlayerNamesProps {
    player1: string;
    player2: string;
    currentTurn: 'player1' | 'player2';
}

export default function PlayerNames({ player1, player2, currentTurn }: PlayerNamesProps) {
    return (
        <div className="flex justify-center mt-4">
            <div className={`mx-4 p-2 rounded ${currentTurn === 'player1' ? 'bg-green-200' : 'bg-gray-200'}`}>
                <p className={`text-lg font-bold ${currentTurn === 'player1' ? 'text-green-700' : 'text-gray-700'}`}>
                    {player1}
                </p>
            </div>
            <div className={`mx-4 p-2 rounded ${currentTurn === 'player2' ? 'bg-green-200' : 'bg-gray-200'}`}>
                <p className={`text-lg font-bold ${currentTurn === 'player2' ? 'text-green-700' : 'text-gray-700'}`}>
                    {player2}
                </p>
            </div>
        </div>
    );
}