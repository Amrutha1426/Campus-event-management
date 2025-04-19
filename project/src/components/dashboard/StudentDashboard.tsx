import React from 'react';
import { Link } from 'react-router-dom';
import { CalendarDays, ChevronRight } from 'lucide-react';
import { useEvents } from '../../context/EventContext';
import { useAuth } from '../../context/AuthContext';
import EventCard from '../events/EventCard';

const StudentDashboard: React.FC = () => {
  const { getUserEvents } = useEvents();
  const { user } = useAuth();
  
  const userEvents = getUserEvents();
  
  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    };
    return new Date(dateString).toLocaleDateString(undefined, options);
  };
  
  return (
    <div>
      <div className="mb-8">
        <h1 className="text-3xl font-bold text-gray-800 mb-2">My Dashboard</h1>
        <p className="text-gray-600">Welcome back, {user?.name}! Manage your event registrations.</p>
      </div>
      
      <div className="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-md p-6 mb-8">
        <div className="flex flex-col md:flex-row md:justify-between md:items-center">
          <div className="text-white mb-4 md:mb-0">
            <h2 className="text-xl font-semibold mb-1">Your Registered Events</h2>
            <p className="opacity-80">You have registered for {userEvents.length} event{userEvents.length !== 1 ? 's' : ''}.</p>
          </div>
          
          <div>
            <Link 
              to="/events" 
              className="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-md hover:bg-blue-50 transition-colors"
            >
              <CalendarDays className="mr-2 h-4 w-4" />
              Browse Events
            </Link>
          </div>
        </div>
      </div>
      
      {userEvents.length === 0 ? (
        <div className="bg-white rounded-lg shadow-md p-8 text-center">
          <div className="mb-4">
            <CalendarDays className="h-12 w-12 mx-auto text-gray-400" />
          </div>
          <h3 className="text-xl font-semibold text-gray-800 mb-2">No Registered Events</h3>
          <p className="text-gray-600 mb-6">You haven't registered for any events yet.</p>
          <Link
            to="/events"
            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
          >
            Browse Available Events
            <ChevronRight className="ml-1 h-4 w-4" />
          </Link>
        </div>
      ) : (
        <div>
          <h3 className="text-xl font-semibold text-gray-800 mb-4">Your Upcoming Events</h3>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {userEvents.map(event => (
              <EventCard key={event.id} event={event} />
            ))}
          </div>
        </div>
      )}
    </div>
  );
};

export default StudentDashboard;