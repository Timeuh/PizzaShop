const db = require('../db');

class CommandesService {
    async getListeCommandes() {
        return db('commande').select('*').orderBy('id', 'desc');
    }

    async getCommandeParId(id) {
        return db.select('*').from('commande').where('id', id).first();
    }

    async getEtapeCommandeParId(id) {
        return db.select('etape').from('commande').where('id', id).first();
    }

    async changerEtatCommande(id) {
        const row = await this.getEtapeCommandeParId(id);

        if (!row || row.etape === null) {
            return { success: false, error: 'Commande non trouvée' };
        }

        let nouvelEtatNum = null;

        if (row.etape === 1) {
            nouvelEtatNum = 2;
        } else if (row.etape === 2) {
            nouvelEtatNum = 3;
        } else {
            return { success: false, error: 'Changement d\'état non autorisé' };
        }

        await db('commande').where('id', id).update({ etape: nouvelEtatNum });
        return { success: true, message: 'État de la commande changé avec succès' };
    }

    async creerCommande() {

    }
}

module.exports = CommandesService;
