import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import { EventProvider } from './context/EventContext';
import Layout from './components/layout/Layout';
import HomePage from './pages/HomePage';
import LoginPage from './pages/LoginPage';
import RegisterPage from './pages/RegisterPage';
import EventsPage from './pages/EventsPage';
import EventDetailsPage from './pages/EventDetailsPage';
import DashboardPage from './pages/DashboardPage';
import AdminDashboardPage from './pages/AdminDashboardPage';
import AddEventPage from './pages/AddEventPage';

function App() {
  return (
    <AuthProvider>
      <EventProvider>
        <Router>
          <Routes>
            <Route path="/" element={<Layout />}>
              <Route index element={<HomePage />} />
              <Route path="login" element={<LoginPage />} />
              <Route path="register" element={<RegisterPage />} />
              <Route path="events" element={<EventsPage />} />
              <Route path="events/:eventId" element={<EventDetailsPage />} />
              <Route path="dashboard" element={<DashboardPage />} />
              <Route path="admin/dashboard" element={<AdminDashboardPage />} />
              <Route path="admin/add-event" element={<AddEventPage />} />
              <Route path="*" element={<Navigate to="/" replace />} />
            </Route>
          </Routes>
        </Router>
      </EventProvider>
    </AuthProvider>
  );
}

export default App;