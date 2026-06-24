'use client';

import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';

export default function Profile() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const router = useRouter();

  useEffect(() => {
    async function fetchUser() {
      try {
        const res = await fetch('/api/auth/me');
        const data = await res.json();
        if (data.logged_in) {
          setUser(data);
        } else {
          router.push('/login');
        }
      } catch (err) {
        console.error('Failed to fetch user data');
        router.push('/login');
      } finally {
        setLoading(false);
      }
    }
    fetchUser();
  }, [router]);

  const handleLogout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST' });
      window.location.href = '/login';
    } catch (error) {
      console.error('Logout failed', error);
    }
  };

  if (loading) return <div style={{ minHeight: '60vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>Loading...</div>;
  if (!user) return null;

  let initials = "?";
  if (user.nama) {
    const words = user.nama.split(" ");
    initials = words[0].charAt(0).toUpperCase();
    if (words.length > 1) {
      initials += words[words.length - 1].charAt(0).toUpperCase();
    }
  }

  return (
    <>
      <section className="page-header" style={{ paddingTop: '150px', paddingBottom: '50px' }}>
        <div className="container">
          <div className="page-header-content">
            <h1>My <span className="text-gradient-cyan">Profile</span></h1>
          </div>
        </div>
      </section>

      <section className="section-padding" style={{ paddingTop: 0 }}>
        <div className="container">
          <div className="profile-container glass-panel" style={{ maxWidth: '600px', margin: '0 auto', padding: '40px', borderTop: '3px solid var(--accent-cyan)', textAlign: 'center' }}>
            <div className="profile-avatar" style={{ width: '120px', height: '120px', borderRadius: '50%', background: 'linear-gradient(135deg, var(--accent-cyan), var(--accent-blue))', color: 'white', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '3rem', margin: '0 auto 20px auto', boxShadow: '0 10px 20px rgba(0,0,0,0.2)' }}>
              {initials}
            </div>
            <div className="profile-info" style={{ marginBottom: '30px' }}>
              <h2 style={{ fontSize: '2rem', marginBottom: '5px' }}>{user.nama}</h2>
              <span className="profile-role" style={{ display: 'inline-block', background: 'rgba(0, 240, 255, 0.1)', color: 'var(--accent-cyan)', padding: '5px 15px', borderRadius: '20px', fontSize: '0.9rem', fontWeight: 600, marginBottom: '20px', textTransform: 'uppercase', letterSpacing: '1px' }}>
                <i className="fa-solid fa-shield-halved"></i> {user.role}
              </span>
            </div>
            
            <div className="profile-details" style={{ background: 'rgba(0, 0, 0, 0.2)', borderRadius: '15px', padding: '20px', textAlign: 'left', marginBottom: '30px' }}>
              <div className="profile-row" style={{ display: 'flex', justifyContent: 'space-between', padding: '12px 0', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
                <div className="profile-label" style={{ color: 'var(--text-secondary)', fontWeight: 500, width: '30%' }}>Nama Lengkap</div>
                <div className="profile-value" style={{ fontWeight: 600, width: '70%', textAlign: 'right', wordBreak: 'break-all' }}>{user.nama}</div>
              </div>
              <div className="profile-row" style={{ display: 'flex', justifyContent: 'space-between', padding: '12px 0', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
                <div className="profile-label" style={{ color: 'var(--text-secondary)', fontWeight: 500, width: '30%' }}>Username</div>
                <div className="profile-value" style={{ fontWeight: 600, width: '70%', textAlign: 'right', wordBreak: 'break-all' }}>{user.username}</div>
              </div>
              <div className="profile-row" style={{ display: 'flex', justifyContent: 'space-between', padding: '12px 0', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
                <div className="profile-label" style={{ color: 'var(--text-secondary)', fontWeight: 500, width: '30%' }}>Email</div>
                <div className="profile-value" style={{ fontWeight: 600, width: '70%', textAlign: 'right', wordBreak: 'break-all' }}>{user.email}</div>
              </div>
              <div className="profile-row" style={{ display: 'flex', justifyContent: 'space-between', padding: '12px 0' }}>
                <div className="profile-label" style={{ color: 'var(--text-secondary)', fontWeight: 500, width: '30%' }}>Akses Role</div>
                <div className="profile-value" style={{ fontWeight: 600, width: '70%', textAlign: 'right', wordBreak: 'break-all' }}>{user.role}</div>
              </div>
            </div>

            <button onClick={handleLogout} className="btn-logout" style={{ width: '100%', padding: '14px', fontSize: '1.1rem', background: 'var(--accent-red)', border: 'none', color: 'white', borderRadius: '8px', cursor: 'pointer', transition: 'all 0.3s ease' }}>
              <i className="fa-solid fa-right-from-bracket"></i> Logout dari Akun
            </button>
          </div>
        </div>
      </section>
    </>
  );
}
