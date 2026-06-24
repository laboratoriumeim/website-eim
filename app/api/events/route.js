import { NextResponse } from 'next/server';
import pool from '@/lib/db';
import { getSession } from '@/lib/auth';

async function isAdmin() {
  const session = await getSession();
  return session?.role === 'admin';
}

export async function GET() {
  try {
    const [rows] = await pool.query('SELECT * FROM events ORDER BY id DESC');
    return NextResponse.json(rows);
  } catch (error) {
    return NextResponse.json({ error: 'Database error' }, { status: 500 });
  }
}

export async function POST(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const [result] = await pool.execute(
      `INSERT INTO events (title, category, status, event_date, description, link, image, icon, organizer, benefits, requirements) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [
        data.title, data.category, data.status, data.event_date, data.description, data.link,
        data.image, data.icon, data.organizer || null,
        data.benefits ? JSON.stringify(data.benefits) : null,
        data.requirements ? JSON.stringify(data.requirements) : null
      ]
    );
    return NextResponse.json({ success: true, id: result.insertId });
  } catch (error) {
    console.error(error);
    return NextResponse.json({ error: 'Failed to create event' }, { status: 500 });
  }
}

export async function PUT(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    await pool.execute(
      `UPDATE events SET title=?, category=?, status=?, event_date=?, description=?, link=?, image=?, icon=?, organizer=?, benefits=?, requirements=? WHERE id=?`,
      [
        data.title, data.category, data.status, data.event_date, data.description, data.link,
        data.image, data.icon, data.organizer || null,
        data.benefits ? JSON.stringify(data.benefits) : null,
        data.requirements ? JSON.stringify(data.requirements) : null,
        data.id
      ]
    );
    return NextResponse.json({ success: true });
  } catch (error) {
    return NextResponse.json({ error: 'Failed to update event' }, { status: 500 });
  }
}

export async function DELETE(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    await pool.execute('DELETE FROM events WHERE id=?', [data.id]);
    return NextResponse.json({ success: true });
  } catch (error) {
    return NextResponse.json({ error: 'Failed to delete event' }, { status: 500 });
  }
}
