import React from 'react';
import { Link } from 'react-router-dom';
import { Calendar, Users, User, CheckCircle } from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import { useEvents } from '../context/EventContext';

const HomePage: React.FC = () => {
  const { user } = useAuth();
  const { events } = useEvents();
  
  // Get upcoming events (first 3)
  const upcomingEvents = [...events]
    .sort((a, b) => new Date(a.date).getTime() - new Date(b.date).getTime())
    .slice(0, 3);
  
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
      {/* Hero Section */}
      <section className="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl overflow-hidden shadow-xl mb-12">
        <div className="container mx-auto px-6 py-16 flex flex-col md:flex-row items-center">
          <div className="md:w-1/2 mb-10 md:mb-0">
            <h1 className="text-4xl md:text-5xl font-bold mb-4 leading-tight">
              Campus Events Management System
            </h1>
            <p className="text-xl md:text-2xl mb-8 opacity-80">
              Discover, register and manage events on your campus with ease
            </p>
            {!user ? (
              <div className="flex flex-col sm:flex-row gap-4">
                <Link
                  to="/register"
                  className="px-6 py-3 bg-white text-blue-600 rounded-md font-semibold hover:bg-blue-50 transition-colors text-center"
                >
                  Sign Up Now
                </Link>
                <Link
                  to="/login"
                  className="px-6 py-3 bg-transparent border-2 border-white text-white rounded-md font-semibold hover:bg-white/10 transition-colors text-center"
                >
                  Login
                </Link>
              </div>
            ) : (
              <Link
                to="/events"
                className="px-6 py-3 bg-white text-blue-600 rounded-md font-semibold hover:bg-blue-50 transition-colors inline-block"
              >
                Browse Events
              </Link>
            )}
          </div>
          <div className="md:w-1/2">
            <img 
              src="https://images.pexels.com/photos/3184393/pexels-photo-3184393.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" 
              alt="Students at event"
              className="rounded-lg shadow-lg object-cover h-64 md:h-96 w-full"
            />
          </div>
        </div>
      </section>
      
      {/* Features Section */}
      <section className="mb-12">
        <div className="text-center mb-10">
          <h2 className="text-3xl font-bold text-gray-800 mb-2">Why Use EventCampus?</h2>
          <p className="text-gray-600 max-w-2xl mx-auto">Our platform makes it easy to manage and participate in campus events</p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="bg-white p-6 rounded-lg shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
            <div className="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
              <Calendar className="h-6 w-6 text-blue-600" />
            </div>
            <h3 className="text-xl font-semibold mb-2 text-gray-800">Easy Event Discovery</h3>
            <p className="text-gray-600">
              Find all campus events in one place with powerful filtering options to find events that interest you.
            </p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
            <div className="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
              <CheckCircle className="h-6 w-6 text-purple-600" />
            </div>
            <h3 className="text-xl font-semibold mb-2 text-gray-800">Simple Registration</h3>
            <p className="text-gray-600">
              Register for events with just one click and manage all your event registrations from your dashboard.
            </p>
          </div>
          
          <div className="bg-white p-6 rounded-lg shadow-md transition-transform hover:-translate-y-1 hover:shadow-lg">
            <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
              <Users className="h-6 w-6 text-green-600" />
            </div>
            <h3 className="text-xl font-semibold mb-2 text-gray-800">Event Management</h3>
            <p className="text-gray-600">
              For event organizers, our platform provides tools to create, manage, and track attendance for events.
            </p>
          </div>
        </div>
      </section>
      
      {/* Upcoming Events Section */}
      <section className="mb-12">
        <div className="flex justify-between items-center mb-6">
          <h2 className="text-2xl font-bold text-gray-800">Upcoming Events</h2>
          <Link to="/events" className="text-blue-600 hover:text-blue-800 font-medium">
            View All Events
          </Link>
        </div>
        
        {upcomingEvents.length === 0 ? (
          <div className="bg-white p-8 rounded-lg shadow-md text-center">
            <p className="text-gray-600">No upcoming events available. Check back later.</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {upcomingEvents.map(event => (
              <div key={event.id} className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div className="h-40 overflow-hidden">
                  <img 
                    src={event.imageUrl || 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'} 
                    alt={event.title}
                    className="w-full h-full object-cover"
                  />
                </div>
                <div className="p-5">
                  <h3 className="text-lg font-bold text-gray-800 mb-2">{event.title}</h3>
                  <p className="text-gray-600 mb-3 line-clamp-2">{event.description}</p>
                  <div className="flex items-center text-gray-600 mb-3">
                    <Calendar className="h-4 w-4 mr-2" />
                    <span>{formatDate(event.date)}</span>
                  </div>
                  <Link
                    to={`/events/${event.id}`}
                    className="block text-center py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                  >
                    View Details
                  </Link>
                </div>
              </div>
            ))}
          </div>
        )}
      </section>
      
      {/* CTA Section */}
      <section className="bg-gray-50 rounded-xl p-8 mb-12">
        <div className="text-center">
          <h2 className="text-3xl font-bold text-gray-800 mb-4">Ready to join campus events?</h2>
          <p className="text-gray-600 mb-6 max-w-2xl mx-auto">
            Create an account now to start discovering and joining events happening on your campus.
          </p>
          {!user ? (
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Link
                to="/register"
                className="px-6 py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition-colors"
              >
                <User className="h-5 w-5 inline mr-2" />
                Create Account
              </Link>
              <Link
                to="/events"
                className="px-6 py-3 bg-gray-800 text-white rounded-md font-semibold hover:bg-gray-900 transition-colors"
              >
                <Calendar className="h-5 w-5 inline mr-2" />
                Browse Events
              </Link>
            </div>
          ) : (
            <Link
              to="/dashboard"
              className="px-6 py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition-colors"
            >
              Go to Dashboard
            </Link>
          )}
        </div>
      </section>
    </div>
  );
};

export default HomePage;