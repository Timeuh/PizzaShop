const amqp = require('amqplib');

class PublicationService {

    constructor() {
        this.rabbitmq = 'amqp://rabbitUser:rabbitPass@rabbitmq:5672';
        this.queue = 'suivi_commandes'
        this.exchange = 'pizzashop';
        this.routingKey = 'suivi';
    }

    async publishMessage(commandeId, nouvelEtat) {
        try {
            const conn = await amqp.connect(this.rabbitmq);
            const channel = await conn.createChannel();

            await channel.assertExchange(this.exchange, 'direct', { durable: true });
            await channel.bindQueue(this.queue, this.exchange, this.routingKey);

            const message = JSON.stringify({ commandeId, nouvelEtat });

            await channel.publish(this.exchange, this.routingKey, Buffer.from(message));

            await channel.close();
            await conn.close();
        } catch (error) {
            console.error('Erreur lors de la publication du message:', error);
        }
    }
}

module.exports = PublicationService;
