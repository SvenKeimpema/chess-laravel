import ChessBoard from '@/components/board/chessboard-preview';
import GamePreview from '../game-preview';

export default function MainContent() {
    return (
        <main className="flex-1 p-6">
            <div className="max-w-6xl mx-auto">
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Left Column */}
                    <div className="lg:col-span-2 space-y-6">
                        <div className="bg-white rounded-lg shadow-md p-4">
                            <h2 className="text-xl font-bold mb-4">
                                Play Chess Online
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <button className="bg-chess-green text-white p-4 rounded-lg hover:bg-green-600 bg-green-400 transition">
                                    <h3 className="font-bold">Play Online</h3>
                                    <p className="text-sm">
                                        Match with a player of your level
                                    </p>
                                </button>
                                <button className="bg-chess-blue text-white p-4 rounded-lg hover:bg-blue-800 bg-blue-500 transition">
                                    <h3 className="font-bold">Play Computer</h3>
                                    <p className="text-sm">
                                        Practice against AI
                                    </p>
                                </button>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-4">
                            <h2 className="text-xl font-bold mb-4">
                                Featured Games
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <GamePreview
                                    title="World Championship"
                                    players="Carlsen vs. Nepomniachtchi"
                                    moves="e4 e5 Nf3 Nc6"
                                />
                                <GamePreview
                                    title="Tata Steel 2023"
                                    players="Giri vs. Ding"
                                    moves="d4 d5 c4 e6"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Right Column */}
                    <div className="space-y-6">
                        <div className="bg-white rounded-lg shadow-md p-4">
                            <h2 className="text-xl font-bold mb-4">
                                Daily Puzzle
                            </h2>
                            <div className="flex justify-center mb-4">
                                <ChessBoard size="small" />
                            </div>
                            <p className="text-sm mb-3">
                                Black to move and win
                            </p>
                            <button className="w-full bg-yellow-500 hover:bg-yellow-600 text-black py-2 rounded">
                                Solve Puzzle
                            </button>
                        </div>

                        <div className="bg-white rounded-lg shadow-md p-4">
                            <h2 className="text-xl font-bold mb-4">
                                Chess News
                            </h2>
                            <ul className="space-y-3">
                                <li className="border-b pb-2">
                                    <a
                                        href="#"
                                        className="hover:text-chess-blue"
                                    >
                                        Carlsen wins another tournament
                                    </a>
                                </li>
                                <li className="border-b pb-2">
                                    <a
                                        href="#"
                                        className="hover:text-chess-blue"
                                    >
                                        New opening trends in 2023
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        className="hover:text-chess-blue"
                                    >
                                        How to improve your endgame
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}
