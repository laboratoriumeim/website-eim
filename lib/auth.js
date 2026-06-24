import jwt from 'jsonwebtoken';
import { cookies } from 'next/headers';

const JWT_SECRET = process.env.JWT_SECRET || 'super-secret-eim-key-2026';

export async function signToken(payload) {
  return jwt.sign(payload, JWT_SECRET, { expiresIn: '1d' });
}

export async function verifyToken(token) {
  try {
    return jwt.verify(token, JWT_SECRET);
  } catch (error) {
    return null;
  }
}

export async function getSession() {
  const cookieStore = await cookies();
  const token = cookieStore.get('eim_session')?.value;
  if (!token) return null;
  return verifyToken(token);
}

export async function setSession(user) {
  const token = await signToken(user);
  const cookieStore = await cookies();
  cookieStore.set('eim_session', token, {
    httpOnly: true,
    secure: process.env.NODE_ENV === 'production',
    sameSite: 'lax',
    path: '/',
    maxAge: 60 * 60 * 24 // 1 day
  });
}

export async function clearSession() {
  const cookieStore = await cookies();
  cookieStore.delete('eim_session');
}
