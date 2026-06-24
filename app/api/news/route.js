import { NextResponse } from 'next/server';
import { supabase } from '@/lib/supabase';
import { getSession } from '@/lib/auth';

async function isAdmin() {
  const session = await getSession();
  return session?.role === 'admin';
}

export async function GET() {
  try {
    const { data: rows, error } = await supabase
      .from('news')
      .select('*')
      .order('date', { ascending: false });

    if (error) throw error;
    return NextResponse.json(rows);
  } catch (error) {
    console.error('Fetch news error:', error);
    return NextResponse.json({ error: 'Database error' }, { status: 500 });
  }
}

export async function POST(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const { data: result, error } = await supabase
      .from('news')
      .insert([{
        title: data.title,
        category: data.category,
        author: data.author,
        date: data.date,
        content: data.content,
        image: typeof data.image === 'string' ? JSON.parse(data.image) : data.image
      }])
      .select();

    if (error) throw error;
    return NextResponse.json({ success: true, id: result?.[0]?.id });
  } catch (error) {
    console.error('Create news error:', error);
    return NextResponse.json({ error: 'Failed to create news' }, { status: 500 });
  }
}

export async function PUT(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const { error } = await supabase
      .from('news')
      .update({
        title: data.title,
        category: data.category,
        author: data.author,
        date: data.date,
        content: data.content,
        image: typeof data.image === 'string' ? JSON.parse(data.image) : data.image
      })
      .eq('id', data.id);

    if (error) throw error;
    return NextResponse.json({ success: true });
  } catch (error) {
    console.error('Update news error:', error);
    return NextResponse.json({ error: 'Failed to update news' }, { status: 500 });
  }
}

export async function DELETE(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const { error } = await supabase
      .from('news')
      .delete()
      .eq('id', data.id);
      
    if (error) throw error;
    return NextResponse.json({ success: true });
  } catch (error) {
    console.error('Delete news error:', error);
    return NextResponse.json({ error: 'Failed to delete news' }, { status: 500 });
  }
}
