import { NextResponse } from 'next/server';
import { v2 as cloudinary } from 'cloudinary';

// Konfigurasi Cloudinary dari .env.local
cloudinary.config({
  cloud_name: process.env.CLOUDINARY_CLOUD_NAME,
  api_key: process.env.CLOUDINARY_API_KEY,
  api_secret: process.env.CLOUDINARY_API_SECRET,
});

export async function POST(request) {
  try {
    const { images } = await request.json(); // Array of base64 strings

    if (!images || !Array.isArray(images) || images.length === 0) {
      return NextResponse.json({ error: 'No images provided' }, { status: 400 });
    }

    const uploadedUrls = [];

    // Proses upload satu per satu
    for (const fileStr of images) {
      if (fileStr.startsWith('http')) {
        // Jika sudah URL (misal edit mode), langsung skip/simpan
        uploadedUrls.push(fileStr);
        continue;
      }
      
      const uploadResponse = await cloudinary.uploader.upload(fileStr, {
        folder: 'eim_website',
        resource_type: 'auto'
      });
      uploadedUrls.push(uploadResponse.secure_url);
    }

    return NextResponse.json({ urls: uploadedUrls });
  } catch (error) {
    console.error('Cloudinary Upload Error:', error);
    return NextResponse.json({ error: 'Failed to upload image' }, { status: 500 });
  }
}
