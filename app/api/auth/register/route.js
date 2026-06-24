import { NextResponse } from 'next/server';
import { supabase } from '@/lib/supabase';
import bcrypt from 'bcryptjs';

export async function POST(req) {
  try {
    const { nama, nim, username, email, telp, password } = await req.json();

    if (!nama || !nim || !username || !email || !telp || !password) {
      return NextResponse.json({ error: 'Semua field wajib diisi' }, { status: 400 });
    }

    const hashedPassword = await bcrypt.hash(password, 10);

    const { error: dbError } = await supabase
      .from('users')
      .insert([
        { nama, username, nim, email, telp, password: hashedPassword }
      ]);

    if (dbError) {
      if (dbError.code === '23505') { // Postgres unique violation error code
        return NextResponse.json({ error: 'Email atau username sudah terdaftar!' }, { status: 409 });
      }
      throw dbError;
    }
    
    return NextResponse.json({ success: true, message: 'Pendaftaran berhasil' });
  } catch (error) {
    console.error('Register error:', error);
    return NextResponse.json({ error: 'Terjadi kesalahan server' }, { status: 500 });
  }
}
