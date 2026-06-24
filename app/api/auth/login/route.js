import { NextResponse } from 'next/server';
import pool from '@/lib/db';
import bcrypt from 'bcryptjs';
import { setSession } from '@/lib/auth';

export async function POST(req) {
  try {
    const { username, password } = await req.json();

    if (!username || !password) {
      return NextResponse.json({ error: 'Username dan password dibutuhkan' }, { status: 400 });
    }

    const [rows] = await pool.execute(
      'SELECT * FROM users WHERE username = ?',
      [username]
    );

    const user = rows[0];

    if (user && await bcrypt.compare(password, user.password)) {
      // Set session cookie
      await setSession({
        id: user.id,
        username: user.nama,
        role: user.role
      });

      return NextResponse.json({ success: true, message: 'Login berhasil' });
    } else {
      return NextResponse.json({ error: 'Username atau password salah!' }, { status: 401 });
    }
  } catch (error) {
    console.error('Login error:', error);
    return NextResponse.json({ error: 'Terjadi kesalahan server' }, { status: 500 });
  }
}
