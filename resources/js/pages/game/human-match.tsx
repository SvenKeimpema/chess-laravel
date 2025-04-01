import ChessBoard from '@/components/board/chessboard-match';
import { BoardProvider } from '@/providers/BoardProvider';
import { ImageProvider } from '@/providers/ImageProvider';

export default function HumanMatch() {
    return (
        <>
            <div>
                <ImageProvider>
                    <BoardProvider>
                        <ChessBoard size="medium" />
                    </BoardProvider>
                </ImageProvider>
            </div>
        </>
    );
}
