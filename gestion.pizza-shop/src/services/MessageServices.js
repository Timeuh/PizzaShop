const db = require('../db');
const amqp = require('amqplib');

class MessageServices {

    constructor(serviceGestionCommandes) {
        this.serviceGestionCommandes = serviceGestionCommandes;
        this.rabbitmq = 'amqp://staff:staff@rabbitmq';
        this.queue = 'nouvelles_commandes';
        this.channel = null;
    }

    async connectToRabbitMQ() {
        try {
            const conn = await amqp.connect(this.rabbitmq);
            this.channel = await conn.createChannel();
            await this.channel.assertQueue(this.queue, { durable: true });
            this.consumeMessages();
        } catch (error) {
            console.error('Erreur lors de la connexion à RabbitMQ:', error);
        }
    }

    consumeMessages() {
        this.channel.consume(this.queue, async (msg) => {
            try {
                console.log('Nouveau message reçu:', msg.content.toString());
                const nouvelleCommande = JSON.parse(msg.content.toString());
                await this.serviceGestionCommandes.creerCommande(nouvelleCommande);

                this.channel.ack(msg);
            } catch (error) {
                console.error('Erreur lors du traitement du message:', error);
                this.channel.nack(msg, false, false);
            }
        });
    }
}

module.exports = MessageServices;
