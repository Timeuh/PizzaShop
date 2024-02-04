class CommandesAction {
    constructor(commandesService,publicationService) {
        this.commandesService = commandesService;
        this.publicationService = publicationService
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

            if (!commande) {
                res.status(404).json({ error: 'Commande non trouvée' });
                return;
            }

            res.json(commande);
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Erreur serveur' });
        }
    }

    async getEtapeCommandeParId(req, res) {
        try {
            const id = req.params.id;
            const etape = await this.commandesService.getEtapeCommandeParId(id);

            if (etape === null) {
                res.status(404).json({ error: 'Commande non trouvée' });
                return;
            }
            publicationService.publishMessage(id,etape)
            res.json({ etape });
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Erreur serveur' });
        }
    }

    async changerEtatCommande(req, res) {
        try {
            const id = req.params.id;
            const result = await this.commandesService.changerEtatCommande(id);

            if (!result.success) {
                res.status(400).json({ error: result.error });
                return;
            }

            res.json({ message: result.message });
        } catch (error) {
            console.error(error);
            res.status(500).json({ error: 'Erreur serveur' });
        }
    }
}

module.exports = CommandesAction;
