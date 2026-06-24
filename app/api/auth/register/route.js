import { NextResponse } from 'next/server';
import pool from '@/lib/db';
import bcrypt from 'bcryptjs';

export async function POST(req) {
  try {
    const { nama, nim, username, email, telp, password } = await req.json();

    if (!nama || !nim || !username || !email || !telp || !password) {
      return NextResponse.json({ error: 'Semua field wajib diisi' }, { status: 400 });
    }

    const hashedPassword = await bcrypt.hash(password, 10);

    try {
      await pool.execute(
        'INSERT INTO users (nama, username, nim, email, telp, password) VALUES (?, ?, ?, ?, ?, ?)',
        [nama, username, nim, email, telp, hashedPassword]
      );
      return NextResponse.json({ success: true, message: 'Pendaftaran berhasil' });
    } catch (dbError) {
      if (dbError.code === 'ER_DUP_ENTRY') {
        return NextResponse.json({ error: 'Email atau username sudah terdaftar!' }, { status: 409 });
      }
      throw dbError;
    }
  } catch (error) {
    console.error('Register error:', error);
    return NextResponse.json({ error: 'Terjadi kesalahan server' }, { status: 500 });
  }
}
