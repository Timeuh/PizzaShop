// src/routes/CommandesRoutes.js
const express = require('express');
const CommandesAction = require('../actions/CommandesAction');
const CommandesService = require('../services/CommandesService');
const PublicationService = require('../services/PublicationService')

const router = express.Router();
const commandesService = new CommandesService();
const publicationService = new PublicationService();
const commandesAction = new CommandesAction(commandesService,publicationService);

router.route('/commandes')
    .get((req, res) => commandesAction.listerCommandes(req, res));

router.route('/commandes/:id')
    .get((req, res) => commandesAction.getCommandeParId(req, res));

router.route('/commandes/:id/etape')
    .patch((req, res) => commandesAction.changerEtatCommande(req, res));

router.route('/commandes/:id/etape')
    .get((req, res) => commandesAction.getEtapeCommandeParId(req, res));

module.exports = router;
