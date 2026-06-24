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
      .from('events')
      .select('*')
      .order('id', { ascending: false });

    if (error) throw error;
    return NextResponse.json(rows);
  } catch (error) {
    console.error('Fetch events error:', error);
    return NextResponse.json({ error: 'Database error' }, { status: 500 });
  }
}

export async function POST(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    
    // Convert strings to JSON if necessary, Supabase handles JSONB natively if we pass an object, 
    // but the incoming `data.image` might be a stringified JSON. 
    // Let's ensure it's safely passed to Supabase.
    
    const { data: result, error } = await supabase
      .from('events')
      .insert([{
        title: data.title,
        category: data.category,
        status: data.status,
        event_date: data.event_date,
        description: data.description,
        link: data.link || null,
        image: typeof data.image === 'string' ? JSON.parse(data.image) : data.image,
        icon: data.icon,
        organizer: data.organizer || null,
        benefits: data.benefits || null,
        requirements: data.requirements || null
      }])
      .select();

    if (error) throw error;
    
    return NextResponse.json({ success: true, id: result?.[0]?.id });
  } catch (error) {
    console.error(error);
    return NextResponse.json({ error: 'Failed to create event' }, { status: 500 });
  }
}

export async function PUT(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    
    const { error } = await supabase
      .from('events')
      .update({
        title: data.title,
        category: data.category,
        status: data.status,
        event_date: data.event_date,
        description: data.description,
        link: data.link || null,
        image: typeof data.image === 'string' ? JSON.parse(data.image) : data.image,
        icon: data.icon,
        organizer: data.organizer || null,
        benefits: data.benefits || null,
        requirements: data.requirements || null
      })
      .eq('id', data.id);

    if (error) throw error;
    return NextResponse.json({ success: true });
  } catch (error) {
    console.error('Update event error:', error);
    return NextResponse.json({ error: 'Failed to update event' }, { status: 500 });
  }
}

export async function DELETE(req) {
  if (!(await isAdmin())) return NextResponse.json({ error: 'Unauthorized' }, { status: 403 });

  try {
    const data = await req.json();
    const { error } = await supabase
      .from('events')
      .delete()
      .eq('id', data.id);
      
    if (error) throw error;
    return NextResponse.json({ success: true });
  } catch (error) {
    console.error('Delete event error:', error);
    return NextResponse.json({ error: 'Failed to delete event' }, { status: 500 });
  }
}
