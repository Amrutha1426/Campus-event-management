import React from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Clock, MapPin, CalendarDays, Users, ArrowLeft, BookOpen } from 'lucide-react';
import { useEvents } from '../../context/EventContext';
import { useAuth } from '../../context/AuthContext';

const EventDetail: React.FC = () => {
  const { eventId } = useParams<{ eventId: string }>();
  const { getEventById, registerForEvent, unregisterFromEvent, isRegistered } = useEvents();
  const { user } = useAuth();
  const navigate = useNavigate();
  
  const event = eventId ? getEventById(eventId) : undefined;
  
  if (!event) {
    return (
      <div className="text-center py-10">
        <h2 className="text-2xl font-bold text-gray-800 mb-4">Event Not Found</h2>
        <p className="text-gray-600 mb-6">The event you're looking for doesn't exist or has been removed.</p>
        <button 
          onClick={() => navigate('/events')}
          className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
        >
          <ArrowLeft className="mr-2 h-4 w-4" />
          Back to Events
        </button>
      </div>
    );
  }
  
  const registered = isRegistered(event.id);
  const capacityPercentage = (event.registeredCount / event.capacity) * 100;
  const isAlmostFull = capacityPercentage >= 80;
  const isFull = event.registeredCount >= event.capacity;
  
  const handleRegister = () => {
    if (registered) {
      unregisterFromEvent(event.id);
    } else {
      registerForEvent(event.id);
    }
  };

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
      <button 
        onClick={() => navigate('/events')}
        className="inline-flex items-center mb-6 text-blue-600 hover:text-blue-800 transition-colors"
      >
        <ArrowLeft className="mr-1 h-4 w-4" />
        Back to Events
      </button>
      
      <div className="bg-white rounded-lg shadow-md overflow-hidden">
        <div className="h-64 md:h-80 relative">
          <img 
            src={event.imageUrl || 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'} 
            alt={event.title}
            className="w-full h-full object-cover"
          />
          <div className="absolute top-0 right-0 m-4 px-3 py-1 rounded-full bg-white text-sm font-medium shadow-sm">
            {event.department}
          </div>
        </div>
        
        <div className="p-6">
          <h1 className="text-3xl font-bold text-gray-800 mb-4">{event.title}</h1>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div className="flex items-center text-gray-600">
              <CalendarDays className="h-5 w-5 mr-2 text-blue-600" />
              <div>
                <p className="text-sm text-gray-500">Date</p>
                <p className="font-medium">{formatDate(event.date)}</p>
              </div>
            </div>
            
            <div className="flex items-center text-gray-600">
              <Clock className="h-5 w-5 mr-2 text-blue-600" />
              <div>
                <p className="text-sm text-gray-500">Time</p>
                <p className="font-medium">{event.time}</p>
              </div>
            </div>
            
            <div className="flex items-center text-gray-600">
              <MapPin className="h-5 w-5 mr-2 text-blue-600" />
              <div>
                <p className="text-sm text-gray-500">Venue</p>
                <p className="font-medium">{event.venue}</p>
              </div>
            </div>
          </div>
          
          <div className="mb-6">
            <h3 className="text-lg font-semibold text-gray-800 mb-2 flex items-center">
              <BookOpen className="h-5 w-5 mr-2 text-blue-600" />
              About This Event
            </h3>
            <p className="text-gray-600 whitespace-pre-line">{event.description}</p>
          </div>
          
          <div className="mb-6">
            <h3 className="text-lg font-semibold text-gray-800 mb-2 flex items-center">
              <Users className="h-5 w-5 mr-2 text-blue-600" />
              Registration Status
            </h3>
            <div className="bg-gray-50 rounded-lg p-4">
              <div className="flex items-center justify-between mb-2">
                <span className="text-gray-600">
                  {event.registeredCount} out of {event.capacity} spots filled
                </span>
                <span className="text-sm font-medium">
                  {isFull ? (
                    <span className="text-red-600">Full</span>
                  ) : isAlmostFull ? (
                    <span className="text-orange-500">Almost Full</span>
                  ) : (
                    <span className="text-green-600">Available</span>
                  )}
                </span>
              </div>
              <div className="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div 
                  className={`h-full ${isFull ? 'bg-red-500' : isAlmostFull ? 'bg-orange-500' : 'bg-green-500'}`}
                  style={{ width: `${Math.min(capacityPercentage, 100)}%` }}
                ></div>
              </div>
            </div>
          </div>
          
          {user && (
            <div className="mt-6 flex justify-center">
              <button
                onClick={handleRegister}
                disabled={!registered && isFull}
                className={`py-3 px-6 rounded-md font-medium text-center transition-colors focus:outline-none focus:ring-2 focus:ring-opacity-50 ${
                  registered
                    ? 'bg-red-100 text-red-600 hover:bg-red-200 focus:ring-red-500'
                    : isFull
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    : 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500'
                }`}
              >
                {registered ? 'Cancel Registration' : isFull ? 'Event Full' : 'Register for this Event'}
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default EventDetail;