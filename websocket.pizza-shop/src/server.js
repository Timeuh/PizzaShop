import { WebSocketServer } from 'ws';
const server = new WebSocketServer({ port: 3000 , clientTracking: true});
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

