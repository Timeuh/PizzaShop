// src/db.js
const knex = require('knex');

const db = knex({
    client: 'mysql',
    connection: {
        host: 'api.gestion.pizza-shop.db', // L'hôte de la base de données
        port: 3306, // Le port de la base de données
        user: 'gestion_user', // Le nom d'utilisateur MySQL
        password: 'gestion_user', // Le mot de passe MySQL
        database: 'gestion', // Le nom de la base de données
    },
});

module.exports = db;