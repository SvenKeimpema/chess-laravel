import { useBoardProvider } from '@/providers/BoardProvider';
import Square from '../square';
import { useEffect, useState } from 'react';
import axios from 'axios';
import { useDeepCompareEffect } from '@/hooks/use-deep-compare-effect';

interface ChessBoardProps {
    size: 'small' | 'medium' | 'large';
}

const sizeClasses = {
    small: 'w-50 h-50',
    medium: 'w-100 h-100',
    large: 'w-200 h-200',
};

export default function ChessBoard({ size = 'medium' }: ChessBoardProps) {
    const { board, moves, reload, status } = useBoardProvider();
    const [selectedSquare, setSelectedSquare] = useState<number | null>(null);
    const [highlightedSquares, setHighlightedSquares] = useState<
        number[] | null
    >(null);

    useDeepCompareEffect(() => {
        setSelectedSquare(null);
        setHighlightedSquares([]);
    }, [board]);

    const leaveMatch = async () => {
        // await axios.post('/api/leave-match');
    };

    useEffect(() => {
        console.log(status);
        if (status.win || status.draw) {
            leaveMatch();
        }
    }, [status]);

    const handleSquareClick = (square: number) => {
        const row = Math.floor(square / 8);
        const col = square % 8;
        const piece = board[row][col];
        const hSquares: number[] = [];

        if (highlightedSquares && highlightedSquares.includes(square)) {
            setSelectedSquare(null);
            setHighlightedSquares([]);

            axios.post('/api/moves/make', {
                startSquare: selectedSquare,
                endSquare: square,
            });

            reload();

            return;
        }

        if (piece !== -1) {
            setSelectedSquare(square);
            moves.forEach((move) => {
                if (move.start == square) hSquares.push(move.end);
            });
            setHighlightedSquares(hSquares);
        }
    };

    const squares = [];
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const isLight = (row + col) % 2 === 0;
            const piece = board[row]?.[col] || 0;
            const square = row * 8 + col;
            const highlighted = highlightedSquares?.includes(square);
            squares.push(
                <Square
                    key={square}
                    onClick={() => handleSquareClick(square)}
                    isLight={isLight}
                    square={square}
                    piece={piece}
                    isSelected={selectedSquare === square}
                    isHighLighted={highlighted || false}
                />,
            );
        }
    }

    return (
        <div className="relative">
            <div
                className={`${sizeClasses[size]} grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}
            >
                {squares}
            </div>
            {status.win && (
                <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div className="bg-white p-4 rounded shadow-lg">
                        <h2 className="text-xl font-bold">Game Over</h2>
                        <p>{status.side} wins!</p>
                    </div>
                </div>
            )}
            {status.draw && (
                <div className="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div className="bg-white p-4 rounded shadow-lg">
                        <h2 className="text-xl font-bold">Game Over</h2>
                        <p>It's a draw!</p>
                    </div>
                </div>
            )}
        </div>
    );
}
