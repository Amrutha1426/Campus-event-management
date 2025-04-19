import React from 'react';
import { Clock, MapPin, CalendarDays, BookOpen, Users } from 'lucide-react';
import { Event } from '../../types';
import { useEvents } from '../../context/EventContext';

interface EventCardProps {
  event: Event;
  showRegisterButton?: boolean;
}

const EventCard: React.FC<EventCardProps> = ({ event, showRegisterButton = true }) => {
  const { registerForEvent, unregisterFromEvent, isRegistered } = useEvents();
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
    <div className="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
      <div className="h-48 overflow-hidden relative">
        <img 
          src={event.imageUrl || 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'} 
          alt={event.title}
          className="w-full h-full object-cover"
        />
        <div className="absolute top-0 right-0 m-2 px-2 py-1 rounded bg-white text-xs font-medium">
          {event.department}
        </div>
      </div>
      
      <div className="p-5">
        <h3 className="text-xl font-bold text-gray-800 mb-2">{event.title}</h3>
        
        <div className="flex items-center text-gray-600 mb-1">
          <CalendarDays className="h-4 w-4 mr-2" />
          <span>{formatDate(event.date)}</span>
        </div>
        
        <div className="flex items-center text-gray-600 mb-1">
          <Clock className="h-4 w-4 mr-2" />
          <span>{event.time}</span>
        </div>
        
        <div className="flex items-center text-gray-600 mb-3">
          <MapPin className="h-4 w-4 mr-2" />
          <span>{event.venue}</span>
        </div>
        
        <p className="text-gray-600 mb-4 line-clamp-2">
          <BookOpen className="h-4 w-4 inline mr-2" />
          {event.description}
        </p>
        
        <div className="mb-4">
          <div className="flex items-center justify-between mb-1">
            <span className="text-sm text-gray-600 flex items-center">
              <Users className="h-4 w-4 mr-1" />
              {event.registeredCount} / {event.capacity}
            </span>
            <span className="text-xs font-medium">
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
        
        {showRegisterButton && (
          <button
            onClick={handleRegister}
            disabled={!registered && isFull}
            className={`w-full py-2 px-4 rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-opacity-50 ${
              registered
                ? 'bg-red-100 text-red-600 hover:bg-red-200 focus:ring-red-500'
                : isFull
                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                : 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500'
            }`}
          >
            {registered ? 'Cancel Registration' : isFull ? 'Event Full' : 'Register Now'}
          </button>
        )}
      </div>
    </div>
  );
};

export default EventCard;