export default function Header({ isLoggedIn }: { isLoggedIn: boolean}) {
    return (
      <header className="bg-chess-blue text-white shadow-md">
        <div className="container mx-auto px-4 py-3 flex justify-between items-center">
          <div className="flex items-center space-x-4">
            <div className="text-2xl font-bold">ChessMaster</div>
            <nav className="hidden md:flex space-x-6">
              <a href="#" className="hover:text-yellow-300">Play</a>
              <a href="#" className="hover:text-yellow-300">Puzzles</a>
              <a href="#" className="hover:text-yellow-300">Learn</a>
              <a href="#" className="hover:text-yellow-300">Watch</a>
              <a href="#" className="hover:text-yellow-300">News</a>
            </nav>
          </div>
          
          {isLoggedIn ? (
            <div className="flex items-center space-x-4">
              <button className="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded">
                Play Online
              </button>
              <div className="w-8 h-8 bg-gray-300 rounded-full"></div>
            </div>
          ) : (
            <div className="flex space-x-3">
              <button className="px-4 py-2 rounded hover:bg-blue-700">Log In</button>
              <button className="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">
                Sign Up
              </button>
            </div>
          )}
        </div>
      </header>
    )
  }