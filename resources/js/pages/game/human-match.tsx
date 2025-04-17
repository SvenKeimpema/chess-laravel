import ChessBoard from '@/components/board/chessboard-match';
import { BoardProvider } from '@/providers/BoardProvider';
import { ImageProvider } from '@/providers/ImageProvider';
import useStatus from '@/hooks/use-status';
import GameWon from '@/components/game-won';
import PlayerNames from '@/components/player-names';
import usePlayerNames from '@/hooks/use-player-names';
import useCurrentSide from '@/hooks/use-side';
import Profile from '@/components/user/profile';

export default function HumanMatch() {
    const { status } = useStatus();
    const { names } = usePlayerNames();
    const { side } = useCurrentSide();
    return (
        <>
            <div className="flex items-center justify-center min-h-screen bg-gray-100">
                <ImageProvider>
                    <Profile />
                    <BoardProvider>
                        <ChessBoard size="medium" />
                        {status.win && <GameWon side={status.side} />}
                        {status.draw && !status.win && (
                            <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                <div className="bg-white p-4 rounded shadow-lg">
                                    <h2 className="text-xl font-bold">
                                        Game Over
                                    </h2>
                                    <p>It's a draw!</p>
                                </div>
                            </div>
                        )}
                    </BoardProvider>
                    <PlayerNames
                        player1={names[0]}
                        player2={names[1]}
                        currentTurn={side}
                    />
                </ImageProvider>
            </div>
        </>
    );
}
