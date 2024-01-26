// src/routes/CommandesRoutes.js
const express = require('express');
const CommandesAction = require('../actions/CommandesAction');
const CommandesService = require('../services/CommandesService');

const router = express.Router();
const commandesService = new CommandesService();
const commandesAction = new CommandesAction(commandesService);

router.route('/commandes')
    .get((req, res) => commandesAction.listerCommandes(req, res));

router.route('/commandes/:id')
    .get((req, res) => commandesAction.getCommandeParId(req, res));

module.exports = router;
