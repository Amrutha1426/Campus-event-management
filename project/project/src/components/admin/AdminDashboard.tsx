import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { Plus, ListFilter, Calendar, User, Trash2 } from 'lucide-react';
import { useEvents } from '../../context/EventContext';

enum View {
  EVENTS,
  REGISTRATIONS
}

const AdminDashboard: React.FC = () => {
  const { events, registrations } = useEvents();
  const [activeView, setActiveView] = useState<View>(View.EVENTS);
  const [selectedEventId, setSelectedEventId] = useState<string | null>(null);
  
  const sortedEvents = [...events].sort((a, b) => {
    return new Date(a.date).getTime() - new Date(b.date).getTime();
  });
  
  const filteredRegistrations = selectedEventId 
    ? registrations.filter(reg => reg.eventId === selectedEventId)
    : registrations;
  
  const calculateRegistrationCount = (eventId: string) => {
    return registrations.filter(reg => reg.eventId === eventId).length;
  };

  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    };
    return new Date(dateString).toLocaleDateString(undefined, options);
  };

  const getEventName = (eventId: string) => {
    const event = events.find(e => e.id === eventId);
    return event ? event.title : 'Unknown Event';
  };
  
  return (
    <div>
      <div className="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div>
          <h1 className="text-3xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
          <p className="text-gray-600">Manage events and registrations</p>
        </div>
        
        <div className="mt-4 lg:mt-0">
          <Link
            to="/admin/add-event"
            className="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
          >
            <Plus className="mr-2 h-4 w-4" />
            Create New Event
          </Link>
        </div>
      </div>
      
      <div className="bg-white rounded-lg shadow-md overflow-hidden">
        <div className="border-b border-gray-200">
          <nav className="flex -mb-px">
            <button
              className={`py-4 px-6 font-medium border-b-2 ${
                activeView === View.EVENTS
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              }`}
              onClick={() => setActiveView(View.EVENTS)}
            >
              <Calendar className="h-5 w-5 inline mr-2" />
              Events
            </button>
            <button
              className={`py-4 px-6 font-medium border-b-2 ${
                activeView === View.REGISTRATIONS
                  ? 'border-blue-500 text-blue-600'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
              }`}
              onClick={() => setActiveView(View.REGISTRATIONS)}
            >
              <User className="h-5 w-5 inline mr-2" />
              Registrations
            </button>
          </nav>
        </div>
        
        <div className="p-6">
          {activeView === View.EVENTS ? (
            <>
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Event Name
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Department
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registrations
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {sortedEvents.length === 0 ? (
                      <tr>
                        <td colSpan={5} className="px-6 py-4 text-center text-gray-500">
                          No events found. Create your first event.
                        </td>
                      </tr>
                    ) : (
                      sortedEvents.map(event => (
                        <tr key={event.id} className="hover:bg-gray-50">
                          <td className="px-6 py-4 whitespace-nowrap">
                            <div className="text-sm font-medium text-gray-900">{event.title}</div>
                            <div className="text-sm text-gray-500 truncate max-w-xs">{event.venue}</div>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <div className="text-sm text-gray-900">{formatDate(event.date)}</div>
                            <div className="text-sm text-gray-500">{event.time}</div>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap">
                            <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                              {event.department}
                            </span>
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {event.registeredCount} / {event.capacity}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <Link
                              to={`/events/${event.id}`}
                              className="text-blue-600 hover:text-blue-900 mr-4"
                            >
                              View
                            </Link>
                            <button
                              onClick={() => {
                                setSelectedEventId(event.id);
                                setActiveView(View.REGISTRATIONS);
                              }}
                              className="text-purple-600 hover:text-purple-900"
                            >
                              Registrations
                            </button>
                          </td>
                        </tr>
                      ))
                    )}
                  </tbody>
                </table>
              </div>
            </>
          ) : (
            <>
              <div className="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                <h3 className="text-lg font-semibold text-gray-800">
                  Event Registrations
                </h3>
                
                <div className="mt-3 md:mt-0 relative">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <ListFilter className="h-5 w-5 text-gray-400" />
                  </div>
                  <select
                    value={selectedEventId || ''}
                    onChange={(e) => setSelectedEventId(e.target.value || null)}
                    className="pl-10 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none"
                  >
                    <option value="">All Events</option>
                    {events.map(event => (
                      <option key={event.id} value={event.id}>{event.title}</option>
                    ))}
                  </select>
                </div>
              </div>
              
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registration ID
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Event
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User ID
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Registration Date
                      </th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {filteredRegistrations.length === 0 ? (
                      <tr>
                        <td colSpan={5} className="px-6 py-4 text-center text-gray-500">
                          No registrations found for the selected event.
                        </td>
                      </tr>
                    ) : (
                      filteredRegistrations.map(registration => (
                        <tr key={registration.id} className="hover:bg-gray-50">
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {registration.id.substring(0, 8)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {getEventName(registration.eventId)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {registration.userId.substring(0, 8)}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {new Date(registration.registrationDate).toLocaleString()}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button className="text-red-600 hover:text-red-900 flex items-center">
                              <Trash2 className="h-4 w-4 mr-1" />
                              Remove
                            </button>
                          </td>
                        </tr>
                      ))
                    )}
                  </tbody>
                </table>
              </div>
            </>
          )}
        </div>
      </div>
    </div>
  );
};

export default AdminDashboard;