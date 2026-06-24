'use client';
import { useState, useEffect } from 'react';
import Link from 'next/link';

export default function EventsPage() {
  const [eventList, setEventList] = useState([]);
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState({ id: null, title: '', category: 'Study Group', status: 'upcoming', event_date: '', description: '', image: '', icon: 'fa-calendar' });
  const [uploadedFiles, setUploadedFiles] = useState([]);
  const [isSaving, setIsSaving] = useState(false);

  const fetchEvents = async () => {
    try {
      const res = await fetch('/api/events');
      if (res.ok) setEventList(await res.json());
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
        await fetchEvents();
      } catch (err) {
        console.error(err);
      } finally {
        setLoading(false);
      }
    }
    fetchData();
  }, []);

  const handleDelete = async (id) => {
    if (!confirm('Apakah Anda yakin ingin menghapus event ini?')) return;
    try {
      const res = await fetch('/api/events', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });
      if (res.ok) {
        setEventList(eventList.filter(e => e.id !== id));
      }
    } catch (e) {
      console.error(e);
    }
  };

  const openAddModal = () => {
    setFormData({ id: null, title: '', category: 'Study Group', status: 'upcoming', event_date: '', description: '', image: '', icon: 'fa-calendar' });
    setUploadedFiles([]);
    setShowModal(true);
  };

  const openEditModal = (event) => {
    setFormData({ ...event });
    let images = [];
    try {
      const parsed = JSON.parse(event.image);
      images = Array.isArray(parsed) ? parsed : [event.image];
    } catch(e) {
      if (event.image) images = [event.image];
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

    // Auto-assign icon based on category
    let icon = 'fa-calendar';
    switch (formData.category) {
      case "Study Group": icon = "fa-graduation-cap"; break;
      case "Kuliah Umum": icon = "fa-chalkboard-user"; break;
      case "Company Visit": icon = "fa-building-columns"; break;
      case "EIM Peduli": icon = "fa-heart"; break;
    }

    try {
      // 1. Upload Images to Cloudinary first
      let finalUrls = [];
      if (uploadedFiles.length > 0) {
        const uploadRes = await fetch('/api/upload', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ images: uploadedFiles })
        });
        
        if (!uploadRes.ok) {
          throw new Error('Gagal mengupload gambar ke Cloudinary');
        }
        const data = await uploadRes.json();
        finalUrls = data.urls;
      } else if (formData.image && formData.image.trim() !== '') {
        // Fallback ke input URL jika tidak ada file yang dipilih
        finalUrls = [formData.image.trim()];
      }

      // 2. Save Event Data with the new URLs
      const payload = { ...formData, icon, image: JSON.stringify(finalUrls) };

      const res = await fetch('/api/events', {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      
      if (res.ok) {
        setShowModal(false);
        fetchEvents();
      } else {
        alert('Gagal menyimpan event');
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
            <h1>Event & <span className="text-gradient-red">Kegiatan</span></h1>
            <p style={{ marginTop: '15px', color: 'var(--text-secondary)' }}>
              Ikuti berbagai event, pelatihan, dan kegiatan riset yang diselenggarakan oleh EIM Research Lab.
            </p>
          </div>
        </div>
      </section>

      <section className="section-padding">
        <div className="container">
          {user?.role === 'admin' && (
            <div style={{ marginBottom: '30px', textAlign: 'right' }}>
              <button className="btn btn-primary" onClick={openAddModal}>
                <i className="fa-solid fa-plus" style={{ marginRight: '8px' }}></i> Tambah Event
              </button>
            </div>
          )}

          {loading ? (
            <p>Loading events...</p>
          ) : eventList.length === 0 ? (
            <div className="news-empty-state">
              <i className="fa-regular fa-folder-open"></i>
              <h3>Belum ada Event</h3>
              <p>Tambahkan event pertama Anda!</p>
            </div>
          ) : (
            <div className="news-grid" id="events-grid">
              {eventList.map(event => {
                const statusClass = event.status === 'completed' ? 'completed' : 'upcoming';
                const statusIcon = event.status === 'completed' ? 'fa-circle-check' : 'fa-clock';
                const statusText = event.status === 'completed' ? 'Completed' : 'Upcoming';

                let coverImg = "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=600";
                try {
                  const parsed = JSON.parse(event.image);
                  if (Array.isArray(parsed) && parsed.length > 0) coverImg = parsed[0];
                } catch (e) {
                  if (event.image) coverImg = event.image;
                }

                return (
                  <div key={event.id} className="event-card glass-panel">
                    <div className="event-cover-img">
                      <img src={coverImg} alt={`Cover ${event.title}`} />
                    </div>
                    <div className={`event-status ${statusClass}`}>
                      <i className={`fa-solid ${statusIcon}`}></i> {statusText}
                    </div>
                    <div className="event-icon">
                      <i className={`fa-solid ${event.icon}`}></i>
                    </div>
                    <h3>{event.title}</h3>
                    <p className="event-cat">Kategori: {event.category}</p>
                    <p>{event.description}</p>

                    <Link href={`/event/${event.id}`} className="btn btn-secondary btn-read-more" style={{ width: '100%', marginTop: '15px', padding: '8px', fontSize: '0.9rem', textAlign: 'center' }}>
                      Baca Selengkapnya <i className="fa-solid fa-arrow-right" style={{ marginLeft: '5px' }}></i>
                    </Link>

                    <div className="event-footer" style={{ marginTop: 'auto', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderTop: '1px solid var(--border-color)', paddingTop: '20px' }}>
                      <span className="event-date"><i className="fa-regular fa-calendar"></i> {event.event_date}</span>
                      {user?.role === 'admin' && (
                        <div className="news-action-btns">
                          <button className="btn-icon btn-icon-edit" onClick={() => openEditModal(event)} title="Edit Event">
                            <i className="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button className="btn-icon btn-icon-delete" onClick={() => handleDelete(event.id)} title="Hapus Event">
                            <i className="fa-solid fa-trash-can"></i>
                          </button>
                        </div>
                      )}
                    </div>
                  </div>
                );
              })}
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
            <h2 style={{ marginBottom: '20px', color: '#111111' }}>{formData.id ? 'Edit Event' : 'Tambah Event'}</h2>
            <form onSubmit={handleSave}>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Judul Event</label>
                <input type="text" className="form-control modal-input" required value={formData.title} onChange={e => setFormData({ ...formData, title: e.target.value })} />
              </div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px', marginBottom: '15px' }}>
                <div className="form-group">
                  <label style={{ color: '#555555' }}>Kategori</label>
                  <select className="form-control modal-input" required value={formData.category} onChange={e => setFormData({ ...formData, category: e.target.value })}>
                    <option value="Study Group">Study Group</option>
                    <option value="Kuliah Umum">Kuliah Umum</option>
                    <option value="Company Visit">Company Visit</option>
                    <option value="EIM Peduli">EIM Peduli</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </div>
                <div className="form-group">
                  <label style={{ color: '#555555' }}>Status</label>
                  <select className="form-control modal-input" required value={formData.status} onChange={e => setFormData({ ...formData, status: e.target.value })}>
                    <option value="upcoming">Upcoming</option>
                    <option value="completed">Completed</option>
                  </select>
                </div>
              </div>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Tanggal Pelaksanaan</label>
                <input type="date" className="form-control modal-input" required value={formData.event_date} onChange={e => setFormData({ ...formData, event_date: e.target.value })} />
              </div>
              <div className="form-group" style={{ marginBottom: '15px' }}>
                <label style={{ color: '#555555' }}>Deskripsi</label>
                <textarea className="form-control modal-input" rows="5" required value={formData.description} onChange={e => setFormData({ ...formData, description: e.target.value })}></textarea>
              </div>
              <div className="form-group" style={{ marginBottom: '25px' }}>
                <label style={{ color: '#555555' }}>Dokumentasi (Maks 10MB/file)</label>
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
