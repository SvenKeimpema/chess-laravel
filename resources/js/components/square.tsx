import { useImageProvider } from '@/providers/ImageProvider';

interface SquareProps {
    square: number;
    piece: number;
    isLight: boolean;
    isSelected: boolean;
    onClick: () => void;
    isHighLighted: boolean;
}

export default function Square({
    square,
    piece,
    isLight,
    isSelected,
    onClick,
    isHighLighted
}: SquareProps) {
    // retriece the blob here and add some make it base64 png
    const { images } = useImageProvider();
    const pieceBlob = images[piece];
    
    return (
        <div
            onClick={onClick}
            key={`${square}`}
            className={`${isSelected ? 'bg-red-500' : isHighLighted ? 'bg-red-200' : isLight ? 'bg-green-200' : 'bg-green-600'} flex items-center justify-center`}
        >
            {pieceBlob && (
                <img
                    src={'data:image/png;base64,' + pieceBlob}
                    alt={`Piece ${piece}`}
                />
            )}
        </div>
    );
}
