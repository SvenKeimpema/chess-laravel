import { useBoardProvider } from '@/providers/BoardProvider';
import Square from '../square';

export default function ChessBoard({
    size = 'medium',
}: {
    size: 'small' | 'medium' | 'large';
}) {
    const { board } = useBoardProvider();
    console.log(board);
    const sizeClasses = {
        small: 'w-50 h-50',
        medium: 'w-100 h-100',
        large: 'w-200 h-200 ',
    };

    const squares = [];

    const SquareClicked = (square: number) => {
        console.log(`Square ${square} clicked`);
    };

    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            const isLight = (row + col) % 2 === 0;
            const piece =
                board.length > row && board[row].length > col
                    ? board[row][col]
                    : 0;
            squares.push(
                <Square
                    onClick={() => {
                        SquareClicked(row * 8 + col);
                    }}
                    isLight={isLight}
                    square={row * 8 + col}
                    piece={piece}
                    isSelected={false}
                />,
            );
        }
    }

    return (
        <div>
            <div
                className={`${sizeClasses[size]} grid grid-cols-8 grid-rows-8 border-2 border-gray-800`}
            >
                {squares}
            </div>
        </div>
    );
}
