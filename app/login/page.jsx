'use client';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState('');
  const router = useRouter();

  const handleLogin = async (e) => {
    e.preventDefault();
    setError('');
    
    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
      });
      
      const data = await res.json();
      if (res.ok) {
        // Force refresh to update Navbar state and redirect
        window.location.href = '/';
      } else {
        setError(data.error || 'Login gagal');
      }
    } catch (err) {
      setError('Terjadi kesalahan server');
    }
  };

  return (
    <>
      <section className="page-header" style={{ paddingTop: '150px', paddingBottom: '50px' }}>
        <div className="container">
          <div className="page-header-content">
            <h1>Login <span className="text-gradient-cyan">Akun</span></h1>
          </div>
        </div>
      </section>

      <section className="section-padding">
        <div className="container">
          <div className="registration-form-container glass-panel" style={{ maxWidth: '500px', margin: '0 auto', padding: '40px', borderTop: '3px solid var(--accent-cyan)' }}>
            <div className="registration-header" style={{ textAlign: 'center', marginBottom: '30px' }}>
              <h2>Masuk ke Akun Anda</h2>
            </div>
            
            {error && (
              <div style={{ backgroundColor: 'rgba(255,0,0,0.1)', color: '#ff6b6b', padding: '10px', borderRadius: '5px', marginBottom: '15px', textAlign: 'center' }}>
                {error}
              </div>
            )}
            
            <form onSubmit={handleLogin}>
              <div className="form-group">
                <label htmlFor="username">Username / Email</label>
                <input 
                  type="text" 
                  className="form-control" 
                  id="username" 
                  placeholder="Username atau Email" 
                  required 
                  value={username}
                  onChange={e => setUsername(e.target.value)}
                />
              </div>
              <div className="form-group" style={{ position: 'relative' }}>
                <label htmlFor="password">Password</label>
                <input 
                  type={showPassword ? 'text' : 'password'} 
                  className="form-control" 
                  id="password" 
                  placeholder="Password" 
                  required 
                  value={password}
                  onChange={e => setPassword(e.target.value)}
                  style={{ paddingRight: '40px' }}
                />
                <button 
                  type="button" 
                  onClick={() => setShowPassword(!showPassword)}
                  style={{ position: 'absolute', right: '10px', top: '35px', background: 'none', border: 'none', color: 'var(--text-secondary)', cursor: 'pointer' }}
                >
                  <i className={`fa-regular ${showPassword ? 'fa-eye-slash' : 'fa-eye'}`}></i>
                </button>
              </div>
              <div className="form-actions" style={{ justifyContent: 'center', marginTop: '40px' }}>
                <button type="submit" className="btn btn-primary" style={{ width: '100%', padding: '14px', fontSize: '1.1rem' }}>
                  Login <i className="fa-solid fa-right-to-bracket" style={{ marginLeft: '8px' }}></i>
                </button>
              </div>
            </form>
            <div style={{ textAlign: 'center', marginTop: '20px' }}>
              Belum punya akun? <Link href="/register" style={{ color: 'var(--accent-cyan)' }}>Daftar di sini</Link>
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
