import React, { useState } from 'react';
import { CalendarDays, Clock, MapPin, BookOpen, Users, Building, Plus } from 'lucide-react';
import { useEvents } from '../../context/EventContext';
import { useNavigate } from 'react-router-dom';

const departments = [
  "Computer Science",
  "Business",
  "Engineering",
  "Fine Arts",
  "Medicine",
  "Law",
  "Science"
];

const AddEventForm: React.FC = () => {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [date, setDate] = useState('');
  const [time, setTime] = useState('');
  const [venue, setVenue] = useState('');
  const [capacity, setCapacity] = useState('');
  const [department, setDepartment] = useState(departments[0]);
  const [imageUrl, setImageUrl] = useState('');
  const [error, setError] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  
  const { addEvent } = useEvents();
  const navigate = useNavigate();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    
    if (!title || !description || !date || !time || !venue || !capacity || !department) {
      setError('All fields are required');
      return;
    }
    
    const capacityNum = parseInt(capacity, 10);
    if (isNaN(capacityNum) || capacityNum <= 0) {
      setError('Capacity must be a positive number');
      return;
    }
    
    setIsLoading(true);
    
    try {
      addEvent({
        title,
        description,
        date,
        time,
        venue,
        capacity: capacityNum,
        department,
        imageUrl,
      });
      
      navigate('/admin/dashboard');
    } catch (err) {
      setError('Failed to create event. Please try again.');
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="bg-white rounded-lg shadow-md">
      <div className="bg-gradient-to-r from-blue-600 to-indigo-700 py-4 px-6 rounded-t-lg">
        <h2 className="text-xl font-bold text-white flex items-center">
          <Plus className="mr-2 h-5 w-5" />
          Create New Event
        </h2>
      </div>
      
      <div className="p-6">
        {error && (
          <div className="mb-4 bg-red-50 text-red-600 p-3 rounded-md border border-red-200">
            {error}
          </div>
        )}
        
        <form onSubmit={handleSubmit}>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="md:col-span-2">
              <label htmlFor="title" className="block text-gray-700 mb-2 font-medium">
                Event Title
              </label>
              <input
                id="title"
                type="text"
                value={title}
                onChange={(e) => setTitle(e.target.value)}
                required
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter event title"
              />
            </div>
            
            <div className="md:col-span-2">
              <label htmlFor="description" className="block text-gray-700 mb-2 font-medium flex items-center">
                <BookOpen className="h-4 w-4 mr-1 text-gray-500" />
                Event Description
              </label>
              <textarea
                id="description"
                value={description}
                onChange={(e) => setDescription(e.target.value)}
                required
                rows={4}
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter event description"
              />
            </div>
            
            <div>
              <label htmlFor="date" className="block text-gray-700 mb-2 font-medium flex items-center">
                <CalendarDays className="h-4 w-4 mr-1 text-gray-500" />
                Date
              </label>
              <input
                id="date"
                type="date"
                value={date}
                onChange={(e) => setDate(e.target.value)}
                required
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
            
            <div>
              <label htmlFor="time" className="block text-gray-700 mb-2 font-medium flex items-center">
                <Clock className="h-4 w-4 mr-1 text-gray-500" />
                Time
              </label>
              <input
                id="time"
                type="text"
                value={time}
                onChange={(e) => setTime(e.target.value)}
                required
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g., 9:00 AM - 5:00 PM"
              />
            </div>
            
            <div>
              <label htmlFor="venue" className="block text-gray-700 mb-2 font-medium flex items-center">
                <MapPin className="h-4 w-4 mr-1 text-gray-500" />
                Venue
              </label>
              <input
                id="venue"
                type="text"
                value={venue}
                onChange={(e) => setVenue(e.target.value)}
                required
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter venue name"
              />
            </div>
            
            <div>
              <label htmlFor="capacity" className="block text-gray-700 mb-2 font-medium flex items-center">
                <Users className="h-4 w-4 mr-1 text-gray-500" />
                Capacity
              </label>
              <input
                id="capacity"
                type="number"
                value={capacity}
                onChange={(e) => setCapacity(e.target.value)}
                required
                min="1"
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Maximum attendees"
              />
            </div>
            
            <div>
              <label htmlFor="department" className="block text-gray-700 mb-2 font-medium flex items-center">
                <Building className="h-4 w-4 mr-1 text-gray-500" />
                Department
              </label>
              <select
                id="department"
                value={department}
                onChange={(e) => setDepartment(e.target.value)}
                required
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none"
              >
                {departments.map(dept => (
                  <option key={dept} value={dept}>{dept}</option>
                ))}
              </select>
            </div>
            
            <div>
              <label htmlFor="imageUrl" className="block text-gray-700 mb-2 font-medium">
                Event Image URL (Optional)
              </label>
              <input
                id="imageUrl"
                type="url"
                value={imageUrl}
                onChange={(e) => setImageUrl(e.target.value)}
                className="block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter image URL"
              />
            </div>
          </div>
          
          <div className="mt-8 flex gap-4 justify-end">
            <button
              type="button"
              onClick={() => navigate('/admin/dashboard')}
              className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              disabled={isLoading}
              className="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 disabled:opacity-50"
            >
              {isLoading ? 'Creating...' : 'Create Event'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default AddEventForm;