// src/actions/CommandesAction.js
class CommandesAction {
    constructor(commandesService) {
        this.commandesService = commandesService;
    }

    async listerCommandes(req, res) {
        try {
            const commandes = await this.commandesService.getListeCommandes();
            res.json(commandes);
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Erreur serveur' });
        }
    }

    async getCommandeParId(req, res) {
        try {
            const id = req.params.id;
            const commande = await this.commandesService.getCommandeParId(id);
            res.json(commande);
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Erreur serveur' });
        }
    }
}

module.exports = CommandesAction;