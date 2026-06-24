-- Paste this into the Supabase SQL Editor and hit "Run"

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nim VARCHAR(20),
  email VARCHAR(100) UNIQUE,
  telp VARCHAR(20),
  role VARCHAR(20) DEFAULT 'user',
  created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
  id SERIAL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  status VARCHAR(20) DEFAULT 'upcoming',
  event_date DATE NOT NULL,
  description TEXT NOT NULL,
  link TEXT,
  image JSONB,
  icon VARCHAR(50) DEFAULT 'fa-calendar',
  organizer VARCHAR(100),
  benefits JSONB,
  requirements JSONB,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE news (
  id SERIAL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL,
  author VARCHAR(100) NOT NULL,
  content TEXT NOT NULL,
  image JSONB,
  date DATE NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- OPTIONAL: Create default admin account directly via SQL 
-- Note: Replace the hash below with a valid bcrypt hash if you want to login directly, 
-- or you can register an account from the website normally and change their role to 'admin' later.
-- This hash is for the password: 'password123'
INSERT INTO users (nama, username, nim, email, telp, password, role) 
VALUES ('Super Admin', 'admin', '000000', 'admin@eim.lab', '08000', '$2a$10$wJ2N2w001m8h92Zk/q7p1eeoO/d6R8oD.R9dY8zQp2O39/uX5M2C2', 'admin');
