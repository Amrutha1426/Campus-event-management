import React from 'react';
import { NavLink, useNavigate } from 'react-router-dom';
import { CalendarDays, LogOut, User } from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

const Header: React.FC = () => {
  const { user, logout, isAdmin } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <header className="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-md">
      <div className="container mx-auto px-4 py-4 flex justify-between items-center">
        <NavLink to="/" className="flex items-center gap-2 text-xl font-bold">
          <CalendarDays className="h-7 w-7" />
          <span>EventCampus</span>
        </NavLink>

        <nav>
          <ul className="flex items-center gap-6">
            {user ? (
              <>
                <li>
                  <NavLink 
                    to="/events" 
                    className={({ isActive }) => `font-medium hover:text-blue-200 transition-colors ${isActive ? 'text-blue-200' : ''}`}
                  >
                    Events
                  </NavLink>
                </li>
                
                {isAdmin() && (
                  <li>
                    <NavLink 
                      to="/admin/dashboard" 
                      className={({ isActive }) => `font-medium hover:text-blue-200 transition-colors ${isActive ? 'text-blue-200' : ''}`}
                    >
                      Admin
                    </NavLink>
                  </li>
                )}
                
                <li>
                  <NavLink 
                    to="/dashboard" 
                    className={({ isActive }) => `font-medium hover:text-blue-200 transition-colors ${isActive ? 'text-blue-200' : ''}`}
                  >
                    My Events
                  </NavLink>
                </li>
                
                <li className="flex items-center gap-2 ml-4">
                  <div className="flex items-center gap-2">
                    <div className="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                      <User className="h-5 w-5" />
                    </div>
                    <span className="hidden md:inline">{user.name}</span>
                  </div>
                  <button 
                    onClick={handleLogout}
                    className="ml-4 p-2 rounded-full hover:bg-blue-500 transition-colors"
                    aria-label="Logout"
                  >
                    <LogOut className="h-5 w-5" />
                  </button>
                </li>
              </>
            ) : (
              <>
                <li>
                  <NavLink 
                    to="/login" 
                    className={({ isActive }) => `font-medium hover:text-blue-200 transition-colors ${isActive ? 'text-blue-200' : ''}`}
                  >
                    Login
                  </NavLink>
                </li>
                <li>
                  <NavLink 
                    to="/register" 
                    className="px-4 py-2 bg-white text-blue-600 rounded-md font-medium hover:bg-blue-50 transition-colors"
                  >
                    Register
                  </NavLink>
                </li>
              </>
            )}
          </ul>
        </nav>
      </div>
    </header>
  );
};

export default Header;