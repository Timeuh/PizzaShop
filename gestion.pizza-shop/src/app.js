// src/app.js
const express = require('express');
const CommandesRoutes = require('./routes/CommandesRoutes');

const app = express();
const port = 3000;

// les routes à l'application
app.use(CommandesRoutes);

app.get('/', (req, res) => {
    res.send('<h1>Routes : </h1><br>' +
        '<h3>/commandes </h3></br>' +
        '<h3>/commandes/:id </h3></br>' +
        '<h3>/commandes/:id/etape </h3>');
});

// Démarrage du serveur
app.listen(port, () => {
    console.log(`Serveur en écoute sur le port ${port}`);
});
