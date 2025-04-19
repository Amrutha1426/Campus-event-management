import React from 'react';
import AddEventForm from '../components/admin/AddEventForm';
import { useAuth } from '../context/AuthContext';
import { Navigate } from 'react-router-dom';

const AddEventPage: React.FC = () => {
  const { user, isAdmin } = useAuth();
  
  if (!user) {
    return <Navigate to="/login" />;
  }
  
  if (!isAdmin()) {
    return <Navigate to="/dashboard" />;
  }
  
  return (
    <div className="max-w-4xl mx-auto">
      <AddEventForm />
    </div>
  );
};

export default AddEventPage;