export default function Footer() {
    return (
      <footer className="bg-chess-dark text-white py-6">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between">
            <div className="mb-4 md:mb-0">
              <h3 className="font-bold text-lg mb-2">ChessMaster</h3>
              <p className="text-sm">The #1 chess platform online</p>
            </div>
            
            <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
              <div>
                <h4 className="font-bold mb-2">Play</h4>
                <ul className="space-y-1 text-sm">
                  <li><a href="#" className="hover:text-yellow-300">Live Chess</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Computer</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Tournaments</a></li>
                </ul>
              </div>
              
              <div>
                <h4 className="font-bold mb-2">Learn</h4>
                <ul className="space-y-1 text-sm">
                  <li><a href="#" className="hover:text-yellow-300">Lessons</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Puzzles</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Practice</a></li>
                </ul>
              </div>
              
              <div>
                <h4 className="font-bold mb-2">Community</h4>
                <ul className="space-y-1 text-sm">
                  <li><a href="#" className="hover:text-yellow-300">Players</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Clubs</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Forums</a></li>
                </ul>
              </div>
              
              <div>
                <h4 className="font-bold mb-2">Company</h4>
                <ul className="space-y-1 text-sm">
                  <li><a href="#" className="hover:text-yellow-300">About</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Careers</a></li>
                  <li><a href="#" className="hover:text-yellow-300">Help</a></li>
                </ul>
              </div>
            </div>
          </div>
          
          <div className="border-t border-gray-700 mt-6 pt-6 text-sm text-center">
            © 2023 ChessMaster. All rights reserved.
          </div>
        </div>
      </footer>
    )
  }