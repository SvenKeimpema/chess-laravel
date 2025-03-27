import ChessBoard from '@/components/board/chess-board';
import { ImageProvider } from '@/providers/ImageProvider';
import React, { useState } from 'react';

const ChessGameLayout = () => {
    const [moves, setMoves] = useState<string[]>([]);
    const [currentMoveIndex, setCurrentMoveIndex] = useState<number>(-1);

    const handleMove = (move: string) => {
        const newMoves = [...moves.slice(0, currentMoveIndex + 1), move];
        setMoves(newMoves);
        setCurrentMoveIndex(newMoves.length - 1);
    };

    const goBack = () => {
        if (currentMoveIndex > 0) {
            setCurrentMoveIndex(currentMoveIndex - 1);
        }
    };

    const goForward = () => {
        if (currentMoveIndex < moves.length - 1) {
            setCurrentMoveIndex(currentMoveIndex + 1);
        }
    };

    return (
        <div>
            <ImageProvider>
                <ChessBoard />
            </ImageProvider>
            <div className="move-display">
                <h2>Moves</h2>
                <ul>
                    {moves.map((move, index) => (
                        <li key={index} className={index === currentMoveIndex ? 'current-move' : ''}>
                            {move}
                        </li>
                    ))}
                </ul>
                <button onClick={goBack} disabled={currentMoveIndex <= 0}>Back</button>
                <button onClick={goForward} disabled={currentMoveIndex >= moves.length - 1}>Forward</button>
            </div>
        </div>
    );
};

export default ChessGameLayout; 