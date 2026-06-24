'use client';
import { useState, useEffect } from 'react';

export default function NewsPage() {
  const [newsList, setNewsList] = useState([]);
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  // Modal State
  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState({ id: null, title: '', category: 'Riset', author: '', content: '', image: '' });
  const [uploadedFiles, setUploadedFiles] = useState([]);
  const [isSaving, setIsSaving] = useState(false);

  const fetchNews = async () => {
    try {
      const newsRes = await fetch('/api/news');
      if (newsRes.ok) setNewsList(await newsRes.json());
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    async function fetchData() {
      try {
        const [authRes] = await Promise.all([
          fetch('/api/auth/me')
        ]);
        if (authRes.ok) setUser(await authRes.json());
        await fetchNews();
      } catch (err) {
        console.error(err);
      } finally {
        setLoading(false);
      }
    }
    fetchData();
  }, []);

  const handleDelete = async (id) => {
    if (!confirm('Apakah Anda yakin ingin menghapus berita ini?')) return;
    try {
      const res = await fetch('/api/news', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });
      if (res.ok) {
        setNewsList(newsList.filter(n => n.id !== id));
      }
    } catch (e) {
      console.error(e);
    }
  };

  const openAddModal = () => {
    setFormData({ id: null, title: '', category: 'Riset', author: user?.nama || '', content: '', image: '' });
    setUploadedFiles([]);
    setShowModal(true);
  };

  const openEditModal = (news) => {
    setFormData({ ...news });
    let images = [];
    try {
      const parsed = JSON.parse(news.image);
      images = Array.isArray(parsed) ? parsed : [news.image];
    } catch(e) {
      if (news.image) images = [news.image];
    }
    setUploadedFiles(images);
    setShowModal(true);
  };

  const handleFileChange = (e) => {
    const files = Array.from(e.target.files);
    let validFiles = [];
    let overSize = false;

    for (const file of files) {
      if (file.size > 10 * 1024 * 1024) {
        overSize = true;
      } else {
        validFiles.push(file);
      }
    }

    if (overSize) alert('Beberapa file diabaikan karena ukurannya melebihi 10MB.');

    Promise.all(validFiles.map(file => {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => resolve(e.target.result);
        reader.onerror = reject;
        reader.readAsDataURL(file);
      });
    })).then(base64Arr => {
      setUploadedFiles(prev => [...prev, ...base64Arr]);
    });
  };

  const removeFile = (index) => {
    setUploadedFiles(prev => prev.filter((_, i) => i !== index));
  };

  const handleSave = async (e) => {
    e.preventDefault();
    setIsSaving(true);
    const method = formData.id ? 'PUT' : 'POST';

    try {
      // Menyimpan data berita dengan gambar base64 ke database langsung
      let finalUrls = [];
      if (uploadedFiles.length > 0) {
        finalUrls = uploadedFiles;
      } else if (formData.image && formData.image.trim() !== '') {
        finalUrls = [formData.image.trim()];
      }

      // 2. Save News Data
      const payload = { ...formData, image: JSON.stringify(finalUrls), date: formData.id ? formData.date : new Date().toISOString().split('T')[0] };

      const res = await fetch('/api/news', {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      if (res.ok) {
        setShowModal(false);
        fetchNews();
      } else {
        alert('Gagal menyimpan berita');
      }
    } catch (e) {
      console.error(e);
      alert(e.message || 'Terjadi kesalahan');
    } finally {
      setIsSaving(false);
    }
  };

  return (
    <>
      <section className="page-header" style={{ paddingTop: '150px', paddingBottom: '50px' }}>
        <div className="container">
          <div className="page-header-content">
            <h1>Berita & <span className="text-gradient-cyan">Artikel</span></h1>
            <p style={{ marginTop: '15px', color: 'var(--text-secondary)' }}>
              Temukan informasi terbaru, kegiatan laboratorium, dan artikel seputar teknologi jaringan.
            </p>
          </div>
        </div>
      </section>

      <section className="section-padding">
        <div className="container">
          {user?.role === 'admin' && (
            <div style={{ marginBottom: '30px', textAlign: 'right' }}>
              <button className="btn btn-primary" onClick={openAddModal}>
                <i className="fa-solid fa-plus" style={{ marginRight: '8px' }}></i> Tambah Berita
              </button>
            </div>
          )}

          {loading ? (
            <p>Loading berita...</p>
          ) : newsList.length === 0 ? (
            <div className="news-empty-state">
              <i className="fa-regular fa-folder-open"></i>
              <h3>Belum ada berita</h3>
              <p>Jadilah yang pertama menambahkan berita baru!</p>
            </div>
          ) : (
            <div className="news-grid">
              {newsList.map(news => (
                <div key={news.id} className="news-card glass-panel">
                  <div className="news-cover">
                    <img src={news.image || "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=600"} alt={news.title} />
                    <div className="news-category">{news.category}</div>
                  </div>
                  <div className="news-content">
                    <div className="news-date">
                      <i className="fa-regular fa-calendar"></i> {new Date(news.date).toLocaleDateString('id-ID')}
                    </div>
                    <h3>{news.title}</h3>
                    <p className="news-desc">{news.content}</p>
                    
                    <div className="news-footer">
                      <span className="news-author"><i className="fa-solid fa-user-pen" style={{ marginRight: '6px', color: 'var(--accent-cyan)' }}></i>{news.author}</span>
                      {user?.role === 'admin' && (
                        <div className="news-action-btns">
                          <button className="btn-icon btn-icon-edit" onClick={() => openEditModal(news)} title="Edit Berita">
                            <i className="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button className="btn-icon btn-icon-delete" onClick={() => handleDelete(news.id)} title="Hapus Berita">
                            <i className="fa-solid fa-trash-can"></i>
                          </button>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </section>

      {/* MODAL */}
      {showModal && (
        <div style={{ position: 'fixed', top: 0, left: 0, right: 0, bottom: 0, zIndex: 9999, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
          <div style={{ position: 'absolute', top: 0, left: 0, right: 0, bottom: 0, background: 'rgba(0,0,0,0.6)', backdropFilter: 'blur(5px)' }} onClick={() => setShowModal(false)}></div>
          <div className="glass-panel" style={{ position: 'relative', width: '90%', maxWidth: '600px', maxHeight: '90vh', overflowY: 'auto', padding: '30px', zIndex: 10000, background: '#ffffff', color: '#333333' }}>
            <button onClick={() => setShowModal(false)} style={{ position: 'absolute', right: '20px', top: '20px', background: 'none', border: 'none', color: '#333333', fontSize: '1.5rem', cursor: 'pointer' }}>&times;</button>
            <h2 style={{ marginBottom: '20px', color: '#111111' }}>{formData.id ? 'Edit Berita' : 'Tambah Berita'}</h2>
            <form onSubmit={handleSave}>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Judul Berita</label>
                <input type="text" className="form-control modal-input" required value={formData.title} onChange={e => setFormData({ ...formData, title: e.target.value })} />
              </div>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Kategori</label>
                <select className="form-control modal-input" required value={formData.category} onChange={e => setFormData({ ...formData, category: e.target.value })}>
                  <option value="Riset">Riset</option>
                  <option value="Kegiatan">Kegiatan</option>
                  <option value="Prestasi">Prestasi</option>
                  <option value="Pengumuman">Pengumuman</option>
                </select>
              </div>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Penulis</label>
                <input type="text" className="form-control modal-input" required value={formData.author} onChange={e => setFormData({ ...formData, author: e.target.value })} />
              </div>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Isi Berita</label>
                <textarea className="form-control modal-input" rows="5" required value={formData.content} onChange={e => setFormData({ ...formData, content: e.target.value })}></textarea>
              </div>
              <div className="form-group" style={{ marginBottom: '25px' }}>
                <label style={{ color: '#555555' }}>Upload Gambar (Maks 10MB/file)</label>
                <input 
                  type="file" 
                  className="form-control modal-input" 
                  multiple 
                  accept="image/*"
                  onChange={handleFileChange} 
                />
                <div style={{ display: 'flex', gap: '10px', marginTop: '10px', flexWrap: 'wrap' }}>
                  {uploadedFiles.map((src, idx) => (
                    <div key={idx} style={{ position: 'relative', width: '80px', height: '80px' }}>
                      <img src={src} alt="preview" style={{ width: '100%', height: '100%', objectFit: 'cover', borderRadius: '5px' }} />
                      <button type="button" onClick={() => removeFile(idx)} style={{ position: 'absolute', top: '-5px', right: '-5px', background: 'red', color: 'white', border: 'none', borderRadius: '50%', width: '20px', height: '20px', cursor: 'pointer', fontSize: '12px' }}>&times;</button>
                    </div>
                  ))}
                </div>
              </div>
              <div style={{ display: 'flex', justifyContent: 'flex-end', gap: '10px' }}>
                <button type="button" className="btn btn-outline" onClick={() => setShowModal(false)} disabled={isSaving}>Batal</button>
                <button type="submit" className="btn btn-primary" disabled={isSaving}>
                  {isSaving ? 'Menyimpan...' : 'Simpan'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
}
