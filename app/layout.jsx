import './globals.css';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';

export const metadata = {
  title: 'EIM Research Lab - Enterprise Infrastructure Management',
  description: 'Website Resmi Enterprise Infrastructure Management (EIM) Research Lab Telkom University.',
  keywords: 'EIM, EIM Research Lab, Telkom University, Enterprise Infrastructure Management, Laboratorium Jaringan, Cloud Computing, Riset Jaringan',
};

export default function RootLayout({ children }) {
  return (
    <html lang="id" suppressHydrationWarning data-scroll-behavior="smooth">
      <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        {/* Modern font */}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
      </head>
      <body suppressHydrationWarning>
        <Navbar />
        {children}
        <Footer />
        <div className="toast-container" id="toast-container"></div>
      </body>
    </html>
  );
}
