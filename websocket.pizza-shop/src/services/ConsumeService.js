import amqp from 'amqplib'

class ConsumeService {

    constructor() {
        this.rabbitmq = 'amqp://rabbitUser:rabbitPass@rabbitmq:5672';
        this.queue = 'suivi_commandes';
    }

    async consumeMessages(callback) {
        try {
            const conn = await amqp.connect(this.rabbitmq);
            const channel = await conn.createChannel();
            await channel.assertQueue(this.queue, {durable: true});

            channel.consume(this.queue, async (msg) => {
                try {
                    console.log('Nouvel état commande:', msg.content.toString());
                    const nouvelleCommande = JSON.parse(msg.content.toString());
                    channel.ack(msg);
                    callback(null, nouvelleCommande);
                } catch (error) {
                    console.error('Erreur lors du traitement du message:', error);
                    channel.nack(msg, false, false);
                    callback(error, null);
                }
            });
        } catch (error) {
            console.error('Erreur lors de la connexion a RabbitMQ:', error);
            callback(error, null);
        }
    }
}

export default ConsumeService;
