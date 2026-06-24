const bcrypt = require('bcryptjs');
const mysql = require('mysql2/promise');

async function run() {
  const pool = mysql.createPool({host:'localhost', user:'root', database:'eim_db'});
  const hashed = await bcrypt.hash('eimsisfo', 10);
  try {
    await pool.execute(
      'INSERT INTO users (nama, username, nim, email, telp, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)',
      ['Admin EIM', 'eimjaya', '000', 'admin@eim.com', '000', hashed, 'admin']
    );
    console.log('Admin inserted');
  } catch(e) {
    if(e.code === 'ER_DUP_ENTRY') {
      await pool.execute('UPDATE users SET role="admin", password=? WHERE username="eimjaya"', [hashed]);
      console.log('Admin updated');
    } else {
      console.log(e);
    }
  }
  process.exit(0);
}
run();
