const express = require('express');
const mysql = require('mysql');

const app = express();
const port = 5000;

// Replace these with your MySQL database credentials
const dbConfig = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'quickcarhire1',
};

const connection = mysql.createConnection(dbConfig);

app.use(express.json());

app.post('/update-location', (req, res) => {
    const { userId, latitude, longitude } = req.body;

    // Insert the location details into the database with separate columns for date and time
    const insertQuery = 'INSERT INTO user_locations (id, latitude, longitude, date, time) VALUES (?, ?, ?, CURDATE(), CURTIME())';
    connection.query(insertQuery, [userId, latitude, longitude], (err, results) => {
        if (err) {
            console.error('Error inserting location into database:', err);
            res.status(500).send('Internal Server Error');
        } else {
            res.status(200).send('Location updated successfully');
        }
    });
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});

// Close the database connection on process exit
process.on('exit', () => {
    connection.end();
});

// Handle Ctrl+C to close the database connection before exiting
process.on('SIGINT', () => {
    connection.end();
    process.exit();
});
