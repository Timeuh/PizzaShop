// src/services/CommandesService.js
const db = require('../db');

class CommandesService {
    async getListeCommandes() {
        const commandes = await db('commande').select('*').orderBy('id', 'desc');
        return commandes;
    }

    async getCommandeParId(id) {
        return db.select('*').from('commande').where('id', id).first();
    }

    async createCommande(description, etat) {
        return db('commande').insert({ description, etat });
    }

    async updateEtatCommande(id, nouvelEtat) {
        return db('commande').where('id', id).update({ etat: nouvelEtat });
    }

    async deleteCommande(id) {
        return await db('commande').where('id', id).del();
    }
}

module.exports = CommandesService;