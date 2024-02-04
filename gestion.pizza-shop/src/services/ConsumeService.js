const amqp = require('amqplib');

class ConsumeService {

    constructor(serviceGestionCommandes) {
        this.serviceGestionCommandes = serviceGestionCommandes;
        this.rabbitmq = 'amqp://staff:staff@rabbitmq:5672';
        this.queue = 'nouvelles_commandes';
    }

    async consumeMessages() {
        try {
            const conn = await amqp.connect(this.rabbitmq);
            const channel = await conn.createChannel();
            await channel.assertQueue(this.queue, {durable: true});

            channel.consume(this.queue, async (msg) => {
                try {
                    console.log('Nouveau message reçu:', msg.content.toString());
                    const nouvelleCommande = JSON.parse(msg.content.toString());
                    await this.serviceGestionCommandes.creerCommande(nouvelleCommande);

                    channel.ack(msg);
                } catch (error) {
                    console.error('Erreur lors du traitement du message:', error);
                    channel.nack(msg, false, false);
                }
            });
        } catch (error) {
            console.error('Erreur lors de la connexion a RabbitMQ:', error);
        }
    }
}

module.exports = ConsumeService;
