export interface User {
  id: string;
  name: string;
  email: string;
  role: 'student' | 'admin';
}

export interface Event {
  id: string;
  title: string;
  description: string;
  date: string;
  time: string;
  venue: string;
  capacity: number;
  department: string;
  registeredCount: number;
  imageUrl: string;
}

export interface Registration {
  id: string;
  eventId: string;
  userId: string;
  registrationDate: string;
}