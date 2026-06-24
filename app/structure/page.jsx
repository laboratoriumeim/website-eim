'use client';
import { useState } from 'react';

const initialMembers = [
  // INTI Division
  { id: 1, name: "Ferdyansyah Adi Saputra", role: "Koordinator Lab EIM", division: "inti", image: "/person/inti/ferday.JPG", scale: "3", position: "center 32%" },
  { id: 2, name: "Raffi Raditya Sofwan", role: "Sekretaris", division: "inti", image: "/person/inti/bewok.JPG", scale: "2.8", position: "55% 35%" },
  { id: 3, name: "Kania Shafa", role: "Bendahara", division: "inti", image: "/person/inti/kania.JPG", scale: "2.7", position: "45% 52%" },

  // RISET Division
  { id: 4, name: "Ardy Maulana", role: "Koordinator Riset", division: "riset", image: "/person/riset/ardyy.JPG", scale: "2.3", position: "53% 15%" },
  { id: 5, name: "Alta", role: "Staff", division: "riset", image: "/person/riset/alta.JPG", scale: "3", position: "49% 35%" },
  { id: 6, name: "Nayla", role: "Staff", division: "riset", image: "/person/riset/nayla.JPG", scale: "3", position: "52% 43%" },
  { id: 7, name: "Hana", role: "Staff", division: "riset", image: "/person/riset/hana.JPG", scale: "3", position: "center 40%" },
  { id: 8, name: "Dara", role: "Staff", division: "riset", image: "/person/riset/dara.JPG", scale: "2.5", position: "48% 34%" },

  // PKU Division
  { id: 9, name: "Winsenlaus Alfero Ivander", role: "Koordinator PKU", division: "pku", image: "/person/pku/lael.JPG", scale: "2.8", position: "50% 13%" },
  { id: 10, name: "Habibi", role: "Staff", division: "pku", image: "/person/pku/habibi.JPG", scale: "2.8", position: "50% 15%" },
  { id: 11, name: "Faiz Dhya", role: "Staff", division: "pku", image: "/person/pku/faiz.JPG", scale: "2.8", position: "50% 15%" },

  // LOMBA Division
  { id: 12, name: "Reza", role: "Koordinator Lomba", division: "lomba", image: "/person/lomba/reza.JPG", scale: "2.8", position: "49% 35%" },
  { id: 13, name: "Ganda", role: "Staff", division: "lomba", image: "/person/lomba/ganda.JPG", scale: "2.8", position: "50% 31%" },
  { id: 14, name: "Frixtho", role: "Staff", division: "lomba", image: "/person/lomba/frixtho.JPG", scale: "2.8", position: "48% 25%" },
  { id: 15, name: "Alif", role: "Staff", division: "lomba", image: "/person/lomba/alif.JPG", scale: "2.8", position: "50% 36%" },

  // MEDHUM Division
  { id: 17, name: "Aura", role: "Koordinator Medhum", division: "medhum", image: "/person/medhum/aura.JPG", scale: "2.2", position: "50% 40%" },
  { id: 18, name: "Firman", role: "Staff", division: "medhum", image: "/person/medhum/firman.JPG", scale: "2.8", position: "50% 33%" },
  { id: 19, name: "Affan", role: "Staff", division: "medhum", image: "/person/medhum/affan.JPG", scale: "2.4", position: "48% 19%" },
  { id: 20, name: "Wildan", role: "Staff", division: "medhum", image: "/person/medhum/wildan.JPG", scale: "2.4", position: "51% 45%" },
  { id: 21, name: "Imam", role: "Staff", division: "medhum" },

  // PENGMAS Division
  { id: 22, name: "Bagas", role: "Koordinator Pengmas", division: "pengmas", image: "/person/pengmas/bagas.JPG", scale: "3", position: "50% 20%" },
  { id: 23, name: "Raya", role: "Staff", division: "pengmas", image: "/person/pengmas/raya.JPG", scale: "2", position: "50% 18%" },
  { id: 24, name: "Salman", role: "Staff", division: "pengmas", image: "/person/pengmas/salman.JPG", scale: "2.3", position: "50% 43%" },
  { id: 25, name: "Kya", role: "Staff", division: "pengmas", image: "/person/pengmas/kya.JPG", scale: "3.3", position: "50% 45%" },
  { id: 26, name: "Rafi", role: "Staff", division: "pengmas", image: "/person/pengmas/rafiakbar.JPG", scale: "2.4", position: "45% 51%" },
];

export default function StructurePage() {
  const [filter, setFilter] = useState('all');

  const filteredMembers = filter === 'all' 
    ? initialMembers 
    : initialMembers.filter(m => m.division.toLowerCase() === filter.toLowerCase());

  return (
    <>
      <section className="page-header" style={{ paddingTop: '150px', paddingBottom: '50px' }}>
        <div className="container">
          <div className="page-header-content">
            <h1>Struktur <span className="text-gradient-cyan">Kepengurusan</span></h1>
            <p style={{ marginTop: '15px', color: 'var(--text-secondary)' }}>Mengenal asisten laboratorium EIM di setiap divisi.</p>
          </div>
        </div>
      </section>

      <section className="section-padding" id="structure">
        <div className="container">
          <div className="filter-container">
            <button className={`filter-tab ${filter === 'all' ? 'active' : ''}`} onClick={() => setFilter('all')}>Semua Divisi</button>
            <button className={`filter-tab ${filter === 'inti' ? 'active' : ''}`} onClick={() => setFilter('inti')}>INTI</button>
            <button className={`filter-tab ${filter === 'riset' ? 'active' : ''}`} onClick={() => setFilter('riset')}>RISET</button>
            <button className={`filter-tab ${filter === 'pku' ? 'active' : ''}`} onClick={() => setFilter('pku')}>PKU</button>
            <button className={`filter-tab ${filter === 'lomba' ? 'active' : ''}`} onClick={() => setFilter('lomba')}>LOMBA</button>
            <button className={`filter-tab ${filter === 'medhum' ? 'active' : ''}`} onClick={() => setFilter('medhum')}>MEDHUM</button>
            <button className={`filter-tab ${filter === 'pengmas' ? 'active' : ''}`} onClick={() => setFilter('pengmas')}>PENGMAS</button>
          </div>

          <div className="member-grid">
            {filteredMembers.map((member, idx) => (
              <div key={member.id} className={`member-card glass-panel div-${member.division}`} style={{ animationDelay: `${idx * 0.06}s` }}>
                <div className="member-avatar-wrapper">
                  <div className="member-avatar" style={member.image ? { background: 'transparent' } : {}}>
                    {member.image ? (
                      <img 
                        src={member.image} 
                        alt={member.name} 
                        style={{ 
                          width: '100%', height: '100%', objectFit: 'cover', borderRadius: 'inherit', display: 'block',
                          transform: member.scale ? `scale(${member.scale})` : 'none',
                          transformOrigin: member.position || 'center'
                        }} 
                      />
                    ) : (
                      <i className="fa-solid fa-user" style={{ fontSize: '2.5rem', opacity: 0.5 }}></i>
                    )}
                  </div>
                </div>
                <div className="member-info">
                  <h3>{member.name}</h3>
                  <div className="member-role">{member.role}</div>
                  <span className="member-div">{member.division.toUpperCase()}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
