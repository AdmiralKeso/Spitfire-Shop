const express = require('express');
const mysql = require('mysql2');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 3000;
const path = require('path');

// Serve static files from the public folder
app.use('/assets', express.static(path.join(__dirname, '../assets')));

// Serve index.html at "/"
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, '../public/index.html'));
});
app.get('/forum', (req, res) => {
  res.sendFile(path.join(__dirname, '../public/forum.html'));
});
app.get('/create', (req, res) => {
  res.sendFile(path.join(__dirname, '../public/create.html'));
});

// MySQL connection
const db = mysql.createConnection({
  host: process.env.DB_HOST,
  port: process.env.DB_PORT,
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME
});

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Route to create a post
app.post('/create-post', (req, res) => {
  const { title, category, sections } = req.body;
  const sectionTexts = JSON.parse(sections); // sections as JSON array

  // Insert post
  db.query('INSERT INTO posts (title, category) VALUES (?, ?)', [title, category], (err, postResult) => {
    if (err) return res.status(500).send(err);
    const postId = postResult.insertId;

    // Insert sections
    sectionTexts.forEach((text, i) => {
      db.query(
        'INSERT INTO post_sections (post_id, section_order, content) VALUES (?, ?, ?)',
        [postId, i + 1, text]
      );
    });

    res.json({ message: 'Post created successfully!' });
  });
});

// Start server
app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));