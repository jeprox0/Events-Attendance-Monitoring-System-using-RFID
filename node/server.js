import { NFC } from 'nfc-pcsc';
import express from 'express';
import cors from 'cors';
import mysql from 'mysql';

const app = express();
const port = 5000;

app.use(cors());
app.use(express.json()); // To parse JSON request bodies

// MySQL connection setup
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', // Use your MySQL root password
    database: 'attendance'
});

db.connect(err => {
    if (err) throw err;
    console.log('Connected to MySQL database');
});

const nfc = new NFC();
let cardUID = ''; // Variable to store the current card UID
let cardPresent = false; // Variable to track if a card is currently present

nfc.on('reader', reader => {
    console.log(`${reader.reader.name} device attached`);

    // Triggered when a card is detected
    reader.on('card', card => {
        console.log(`Card detected, UID: ${card.uid}`);
        cardUID = card.uid; // Store the UID
        cardPresent = true; // Mark card as present
    });

    // Triggered when a card is removed
    reader.on('card.off', card => {
        console.log(`Card removed, UID: ${cardUID}`);
        cardPresent = false; // Mark card as removed
        cardUID = ''; // Clear the UID
    });

    // Handle reader errors
    reader.on('error', err => {
        console.error(`Error: ${err}`);
    });

    // Triggered when the reader is disconnected
    reader.on('end', () => {
        console.log(`${reader.reader.name} device removed`);
    });
});

// Global NFC error handler
nfc.on('error', err => {
    console.error(`NFC Error: ${err}`);
});

// Endpoint to get the last detected card's UID and its status (present or removed)
app.get('/card', (req, res) => {
    res.json({ uid: cardUID, present: cardPresent });
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
