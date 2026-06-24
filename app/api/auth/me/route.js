import { NextResponse } from 'next/server';
import { getSession } from '@/lib/auth';

export async function GET() {
  const session = await getSession();
  
  if (session) {
    return NextResponse.json({
      logged_in: true,
      user_id: session.id,
      user_name: session.username,
      role: session.role
    });
  } else {
    return NextResponse.json({
      logged_in: false,
      role: 'guest'
    });
  }
}
