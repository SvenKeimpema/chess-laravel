import { useBoardProvider } from '@/providers/BoardProvider';
import Square from '../square';
import { useState } from 'react';

interface ChessBoardProps {
    size: 'small' | 'medium' | 'large';
}

const sizeClasses = {
    small: 'w-50 h-50',
    medium: 'w-100 h-100',
    large: 'w-200 h-200',
};

export default function ChessBoard({ size = 'medium' }: ChessBoardProps) {
    const { board } = useBoardProvider();
    const [selectedSquare, setSelectedSquare] = useState<number | null>(null);

    const handleSquareClick = (square: number) => {
        const row = Math.floor(square / 8);
        const col = square % 8;
        const piece = board[row][col];
        if (piece !== -1) {
            setSelectedSquare(square);
        }
    };

    const squares = [];
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const isLight = (row + col) % 2 === 0;
            const piece = board[row]?.[col] || 0;
            const square = row * 8 + col;

            squares.push(
                <Square
                    key={square}
                    onClick={() => handleSquareClick(square)}
                    isLight={isLight}
                    square={square}
                    piece={piece}
                    isSelected={selectedSquare === square}
                />,
            );
        }
    }

    return (
        <div
            className={`${sizeClasses[size]} grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}
        >
            {squares}
        </div>
    );
}
