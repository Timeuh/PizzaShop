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

    async creerCommande(commande) {
        try {
            const newCommande = await db('commande').insert({
                delai: 0,
                id: commande.id,
                date_commande: commande.date_commande,
                type_livraison: commande.type_livraison,
                etape: 1, // État 1 / RECUE
                montant_total: commande.montant_total,
                mail_client: commande.mail_client,
            });
            return newCommande;
        } catch (error) {
            console.error('Erreur lors de la création de la commande:', error);
            throw error;
        }
    }
}

module.exports = CommandesService;
