const mysql = require('mysql2/promise');
const bcrypt = require('bcryptjs');

async function resetDB() {
  try {
    const conn = await mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: ''
    });

    console.log('Mengosongkan dan membuat ulang database eim_db...');
    await conn.query('DROP DATABASE IF EXISTS eim_db');
    await conn.query('CREATE DATABASE eim_db');
    await conn.query('USE eim_db');

    console.log('Membuat tabel users...');
    await conn.query(`
      CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        nim VARCHAR(20),
        email VARCHAR(100) UNIQUE,
        telp VARCHAR(20),
        role ENUM('admin', 'user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `);

    console.log('Membuat tabel events...');
    await conn.query(`
      CREATE TABLE events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        status ENUM('upcoming', 'completed') DEFAULT 'upcoming',
        event_date DATE NOT NULL,
        description TEXT NOT NULL,
        image JSON,
        icon VARCHAR(50) DEFAULT 'fa-calendar',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `);

    console.log('Membuat tabel news...');
    await conn.query(`
      CREATE TABLE news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        author VARCHAR(100) NOT NULL,
        content TEXT NOT NULL,
        image JSON,
        date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `);

    console.log('Menambahkan akun Admin Utama...');
    const hashedPassword = await bcrypt.hash('eimsisfo', 10);
    await conn.query(
      'INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)',
      ['Admin EIM', 'eimjaya', hashedPassword, 'admin']
    );

    console.log('✅ Berhasil! Database telah dikosongkan dan disiapkan kembali dengan struktur baru.');
    console.log('✅ Akun Admin (User: eimjaya | Pass: eimsisfo) telah ditambahkan.');
    process.exit(0);
  } catch (error) {
    console.error('❌ Gagal mereset database. Pastikan XAMPP MySQL Anda SUDAH MENYALA!', error.message);
    process.exit(1);
  }
}

resetDB();
