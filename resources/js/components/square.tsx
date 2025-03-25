import { useImageProvider } from "@/providers/ImageProvider"

export default function Square({ square, piece, isLight }: {square: number, piece: number, isLight: boolean}) {
	// retriece the blob here and add some make it base64 png
  const { images } = useImageProvider();
  const pieceBlob = images[piece];

  console.log(pieceBlob)
  
	return (
        <div 
            key={`${square}`}
            className={`${isLight ? 'bg-green-200' : 'bg-green-600'} flex items-center justify-center`}
          >
            {pieceBlob && <img src={"data:image/png;base64," + pieceBlob} alt={`Piece ${piece}`} />}
          </div>
    )
}