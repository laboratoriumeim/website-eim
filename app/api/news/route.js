import { NextResponse } from 'next/server';
import pool from '@/lib/db';
import { getSession } from '@/lib/auth';

async function isAdmin() {
  const session = await getSession();
  return session?.role === 'admin';
}

export async function GET() {
  try {
    const [rows] = await pool.query('SELECT * FROM news ORDER BY news_date DESC');
    const formatted = rows.map(n => ({
      ...n,
      date: n.news_date
    }));
    return NextResponse.json(formatted);
  } catch (error) {
    return NextResponse.json({ error: 'Database error' }, { status: 500 });
  }
}

export async function POST(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const [result] = await pool.execute(
      `INSERT INTO news (title, category, author, news_date, content, image) VALUES (?, ?, ?, ?, ?, ?)`,
      [data.title, data.category, data.author, data.date, data.content, data.image]
    );
    return NextResponse.json({ success: true, id: result.insertId });
  } catch (error) {
    return NextResponse.json({ error: 'Failed to create news' }, { status: 500 });
  }
}

export async function PUT(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    await pool.execute(
      `UPDATE news SET title=?, category=?, author=?, news_date=?, content=?, image=? WHERE id=?`,
      [data.title, data.category, data.author, data.date, data.content, data.image, data.id]
    );
    return NextResponse.json({ success: true });
  } catch (error) {
    return NextResponse.json({ error: 'Failed to update news' }, { status: 500 });
  }
}

export async function DELETE(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    await pool.execute('DELETE FROM news WHERE id=?', [data.id]);
    return NextResponse.json({ success: true });
  } catch (error) {
    return NextResponse.json({ error: 'Failed to delete news' }, { status: 500 });
  }
}
