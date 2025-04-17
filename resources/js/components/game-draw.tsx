export default function GameDraw() {
    return (
        <div className="absolute inset-0 flex items-center justify-center bg-opacity-40">
            <div className="bg-white opacity-90 bg-opacity-20 p-6 rounded-lg shadow-xl">
                <h2 className="text-2xl text-black font-bold mb-2">
                    Game Over
                </h2>
                <p className="text-lg text-black">It's a draw!</p>
            </div>
        </div>
    );
}
