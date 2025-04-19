import React from 'react';
import StudentDashboard from '../components/dashboard/StudentDashboard';
import { useAuth } from '../context/AuthContext';
import { Navigate } from 'react-router-dom';

const DashboardPage: React.FC = () => {
  const { user } = useAuth();
  
  if (!user) {
    return <Navigate to="/login" />;
  }
  
  return (
    <div>
      <StudentDashboard />
    </div>
  );
};

export default DashboardPage;