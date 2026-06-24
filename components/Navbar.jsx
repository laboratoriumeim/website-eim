'use client';

import { useState, useEffect } from 'react';
import Link from 'next/link';
import { usePathname } from 'next/navigation';

export default function Navbar() {
  const [isOpen, setIsOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [user, setUser] = useState(null);
  const pathname = usePathname();

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 50) {
        setScrolled(true);
      } else {
        setScrolled(false);
      }
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  useEffect(() => {
    async function checkAuth() {
      try {
        const res = await fetch('/api/auth/me');
        if (res.ok) {
          const data = await res.json();
          if (data.logged_in) setUser(data);
        }
      } catch (error) {
        console.error('Failed to fetch auth', error);
      }
    }
    checkAuth();
  }, []);

  const handleLogout = async (e) => {
    e.preventDefault();
    try {
      const res = await fetch('/api/auth/logout', { method: 'POST' });
      if (res.ok) {
        setUser(null);
        window.location.href = '/login';
      }
    } catch (error) {
      console.error('Logout failed', error);
    }
  };

  const closeMenu = () => setIsOpen(false);

  return (
    <nav className={`navbar ${scrolled ? 'scrolled' : ''}`} id="navbar">
      <div className="container">
        <Link href="/" className="logo-container" onClick={closeMenu}>
          <div className="logo-icon">
            <img src="/img/EIM Only Logo.png" alt="EIM Logo" />
          </div>
          <div className="logo-text">
            <span className="text-gradient-dual">EIM</span>
            <span className="logo-sub">Research Lab</span>
          </div>
        </Link>

        <ul className={`nav-links ${isOpen ? 'active' : ''}`} id="nav-links">
          <li className={pathname === '/' ? 'active' : ''}><Link href="/" onClick={closeMenu}>Home</Link></li>
          <li className={pathname === '/about' ? 'active' : ''}><Link href="/about" onClick={closeMenu}>About</Link></li>
          <li className={pathname === '/event' ? 'active' : ''}><Link href="/event" onClick={closeMenu}>Event</Link></li>
          <li className={pathname === '/structure' ? 'active' : ''}><Link href="/structure" onClick={closeMenu}>Structure</Link></li>
          <li className={pathname === '/news' ? 'active' : ''}><Link href="/news" onClick={closeMenu}>News</Link></li>
          
          {user ? (
            <>
              <li className={pathname === '/pendaftaran' ? 'active' : ''}><Link href="/pendaftaran" onClick={closeMenu}>Pendaftaran</Link></li>
              <li className={pathname === '/profile' ? 'active' : ''}>
                <Link href="/profile" className="btn btn-outline" style={{ padding: '8px 20px', borderRadius: '20px' }} onClick={closeMenu}>
                  <i className="fa-regular fa-user" style={{ marginRight: '5px' }}></i> {user.nama || 'Profile'}
                </Link>
              </li>
            </>
          ) : (
            <li><Link href="/login" className="btn btn-primary" style={{ padding: '8px 20px', borderRadius: '20px' }} onClick={closeMenu}>Login</Link></li>
          )}
        </ul>

        <div className={`nav-toggle ${isOpen ? 'active' : ''}`} onClick={() => setIsOpen(!isOpen)}>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>
  );
}
