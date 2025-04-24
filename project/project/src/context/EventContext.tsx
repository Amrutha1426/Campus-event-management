import React, { createContext, useContext, useState, useEffect } from 'react';
import { Event, Registration } from '../types';
import { useAuth } from './AuthContext';

// Sample data for initial events
const sampleEvents: Event[] = [
  {
    id: '1',
    title: 'Annual Tech Conference',
    description: 'Join us for a day of technology discussions, workshops, and networking.',
    date: '2025-06-15',
    time: '9:00 AM - 5:00 PM',
    venue: 'Main Campus Auditorium',
    capacity: 200,
    department: 'Computer Science',
    registeredCount: 87,
    imageUrl: 'https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
  },
  {
    id: '2',
    title: 'Business Leadership Summit',
    description: 'Learn from industry leaders about modern business strategies and leadership skills.',
    date: '2025-07-22',
    time: '10:00 AM - 3:00 PM',
    venue: 'Business School Hall',
    capacity: 150,
    department: 'Business',
    registeredCount: 42,
    imageUrl: 'https://images.pexels.com/photos/1181435/pexels-photo-1181435.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
  },
  {
    id: '3',
    title: 'Arts & Media Exhibition',
    description: 'Showcasing student artwork and media productions from the past year.',
    date: '2025-08-10',
    time: '1:00 PM - 7:00 PM',
    venue: 'Arts Building Gallery',
    capacity: 100,
    department: 'Fine Arts',
    registeredCount: 63,
    imageUrl: 'https://images.pexels.com/photos/1266808/pexels-photo-1266808.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
  },
  {
    id: '4',
    title: 'Engineering Innovation Expo',
    description: 'Discover the latest engineering innovations and research projects.',
    date: '2025-09-05',
    time: '11:00 AM - 4:00 PM',
    venue: 'Engineering Complex',
    capacity: 180,
    department: 'Engineering',
    registeredCount: 120,
    imageUrl: 'https://images.pexels.com/photos/3862632/pexels-photo-3862632.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
  },
];

interface EventContextType {
  events: Event[];
  registrations: Registration[];
  addEvent: (event: Omit<Event, 'id' | 'registeredCount'>) => void;
  registerForEvent: (eventId: string) => void;
  unregisterFromEvent: (eventId: string) => void;
  isRegistered: (eventId: string) => boolean;
  getUserEvents: () => Event[];
  getEventById: (eventId: string) => Event | undefined;
}

const EventContext = createContext<EventContextType | undefined>(undefined);

export const useEvents = () => {
  const context = useContext(EventContext);
  if (context === undefined) {
    throw new Error('useEvents must be used within an EventProvider');
  }
  return context;
};

export const EventProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [events, setEvents] = useState<Event[]>([]);
  const [registrations, setRegistrations] = useState<Registration[]>([]);
  const { user } = useAuth();

  useEffect(() => {
    // Load events from localStorage or use sample data
    const storedEvents = localStorage.getItem('events');
    if (storedEvents) {
      setEvents(JSON.parse(storedEvents));
    } else {
      setEvents(sampleEvents);
      localStorage.setItem('events', JSON.stringify(sampleEvents));
    }

    // Load registrations from localStorage
    const storedRegistrations = localStorage.getItem('registrations');
    if (storedRegistrations) {
      setRegistrations(JSON.parse(storedRegistrations));
    }
  }, []);

  const addEvent = (eventData: Omit<Event, 'id' | 'registeredCount'>) => {
    const newEvent: Event = {
      ...eventData,
      id: Math.random().toString(36).substring(2, 9),
      registeredCount: 0,
    };
    
    const updatedEvents = [...events, newEvent];
    setEvents(updatedEvents);
    localStorage.setItem('events', JSON.stringify(updatedEvents));
  };

  const registerForEvent = (eventId: string) => {
    if (!user) return;
    
    // Check if already registered
    if (isRegistered(eventId)) return;
    
    // Create registration
    const newRegistration: Registration = {
      id: Math.random().toString(36).substring(2, 9),
      eventId,
      userId: user.id,
      registrationDate: new Date().toISOString(),
    };
    
    // Update registrations
    const updatedRegistrations = [...registrations, newRegistration];
    setRegistrations(updatedRegistrations);
    localStorage.setItem('registrations', JSON.stringify(updatedRegistrations));
    
    // Update event registeredCount
    const updatedEvents = events.map(event => {
      if (event.id === eventId) {
        return {
          ...event,
          registeredCount: event.registeredCount + 1,
        };
      }
      return event;
    });
    
    setEvents(updatedEvents);
    localStorage.setItem('events', JSON.stringify(updatedEvents));
  };

  const unregisterFromEvent = (eventId: string) => {
    if (!user) return;
    
    // Find registration
    const registrationToRemove = registrations.find(
      reg => reg.eventId === eventId && reg.userId === user.id
    );
    
    if (!registrationToRemove) return;
    
    // Update registrations
    const updatedRegistrations = registrations.filter(reg => reg.id !== registrationToRemove.id);
    setRegistrations(updatedRegistrations);
    localStorage.setItem('registrations', JSON.stringify(updatedRegistrations));
    
    // Update event registeredCount
    const updatedEvents = events.map(event => {
      if (event.id === eventId) {
        return {
          ...event,
          registeredCount: Math.max(0, event.registeredCount - 1),
        };
      }
      return event;
    });
    
    setEvents(updatedEvents);
    localStorage.setItem('events', JSON.stringify(updatedEvents));
  };

  const isRegistered = (eventId: string) => {
    if (!user) return false;
    return registrations.some(reg => reg.eventId === eventId && reg.userId === user.id);
  };

  const getUserEvents = () => {
    if (!user) return [];
    
    const userRegistrations = registrations.filter(reg => reg.userId === user.id);
    return events.filter(event => userRegistrations.some(reg => reg.eventId === event.id));
  };

  const getEventById = (eventId: string) => {
    return events.find(event => event.id === eventId);
  };

  return (
    <EventContext.Provider value={{
      events,
      registrations,
      addEvent,
      registerForEvent,
      unregisterFromEvent,
      isRegistered,
      getUserEvents,
      getEventById,
    }}>
      {children}
    </EventContext.Provider>
  );
};