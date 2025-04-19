import React from 'react';
import AdminDashboard from '../components/admin/AdminDashboard';
import { useAuth } from '../context/AuthContext';
import { Navigate } from 'react-router-dom';

const AdminDashboardPage: React.FC = () => {
  const { user, isAdmin } = useAuth();
  
  if (!user) {
    return <Navigate to="/login" />;
  }
  
  if (!isAdmin()) {
    return <Navigate to="/dashboard" />;
  }
  
  return (
    <div>
      <AdminDashboard />
    </div>
  );
};

export default AdminDashboardPage;