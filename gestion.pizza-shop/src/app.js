// src/app.js
const express = require('express');
const CommandesRoutes = require('./routes/CommandesRoutes');

const app = express();
const port = 3000;

// les routes à l'application
app.use(CommandesRoutes);

app.get('/', (req, res) => {
    res.send('Hello World!');
});

// Démarrage du serveur
app.listen(port, () => {
    console.log(`Serveur en écoute sur le port ${port}`);
});
