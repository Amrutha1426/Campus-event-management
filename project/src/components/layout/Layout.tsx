import React from 'react';
import { Outlet } from 'react-router-dom';
import Header from './Header';
import Footer from './Footer';

const Layout: React.FC = () => {
  return (
    <div className="flex flex-col min-h-screen">
      <Header />
      <main className="container mx-auto px-4 py-8 flex-grow">
        <Outlet />
      </main>
      <Footer />
    </div>
  );
};

export default Layout;