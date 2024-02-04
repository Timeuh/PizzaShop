import { WebSocketServer } from 'ws';
import ConsumeService from "./services/ConsumeService.js";

const server = new WebSocketServer({ port: 3000 , clientTracking: true});
const consumeService = new ConsumeService();

const notifyAll = (msg) =>{
  server.clients.forEach((client_socket) => {
    if (client_socket.readyState === WebSocket.OPEN)
      client_socket.send(msg);
  });
}

//const clients = [{clientSocket : ...., numCommande: ....} ]
const clients = [ ]
server.on('connection', (client_socket) => {
    client_socket.addEventListener('message', (message) => {
      clients.push({clientSocket: client_socket, numCommande : message.data})
        client_socket.send('Vous êtes abonné au suivi de la commande numéro : ' + message.data );
        }
      )
});


// consomme les messages de mise à jour commande
consumeService.consumeMessages((error, nouvelleCommande) => {
  if (error) {
    console.log(error);
    return;
  }

  // recherche le client avec le bon numero de commande
  const clientCommande = clients.find(client => client.numCommande === nouvelleCommande.numCommande);

  // notifie le client
  if (clientCommande.clientSocket.readyState === WebSocket.OPEN) {
    clientCommande.clientSocket.send('La commande ' + nouvelleCommande.numCommande + ' a été mise à jour : ' + JSON.stringify(nouvelleCommande));
  }
});
