export default function MainContent() {
    return (
        <main className="flex-1 flex items-center justify-center p-12">
            <div className="max-w-6xl w-full mx-auto">
                <div className="bg-white rounded-lg shadow-2xl p-12 transform">
                    <h2 className="text-4xl font-extrabold mb-8 text-center text-gray-900">
                        Welcome to Chess Online
                    </h2>
                    <div className="flex justify-center">
                        <button onClick={() => { window.location.href = "/matchmaking"}} className="bg-gradient-to-r from-green-400 to-blue-500 text-white py-4 px-8 rounded-full shadow-lg hover:shadow-2xl transition duration-500 ease-in-out transform hover:scale-110">
                            <h3 className="text-xl font-bold">Play Online</h3>
                            <p className="text-sm">
                                Match with a random player
                            </p>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    );
}