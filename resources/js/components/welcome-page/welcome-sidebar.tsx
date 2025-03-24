export default function Sidebar() {
    return (
      <aside className="w-64 bg-chess-dark text-white p-4 hidden lg:block">
        <div className="mb-6">
          <h3 className="font-bold text-lg mb-3">Games</h3>
          <ul className="space-y-2">
            <li><a href="#" className="hover:text-yellow-300 block">Live Chess</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Daily Chess</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Chess960</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Tournaments</a></li>
          </ul>
        </div>
        
        <div className="mb-6">
          <h3 className="font-bold text-lg mb-3">Community</h3>
          <ul className="space-y-2">
            <li><a href="#" className="hover:text-yellow-300 block">Players</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Clubs</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Forums</a></li>
          </ul>
        </div>
        
        <div>
          <h3 className="font-bold text-lg mb-3">Tools</h3>
          <ul className="space-y-2">
            <li><a href="#" className="hover:text-yellow-300 block">Analysis Board</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Opening Explorer</a></li>
            <li><a href="#" className="hover:text-yellow-300 block">Practice</a></li>
          </ul>
        </div>
      </aside>
    )
  }