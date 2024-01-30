import { WebSocketServer } from 'ws';
const server = new WebSocketServer({ port: 3000 , clientTracking: true});
const notifyAll = (msg) =>{
  server.clients.forEach((client_socket) => {
    if (client_socket.readyState === WebSocket.OPEN)
      client_socket.send(msg);
  });
}
server.on('connection', (client_socket) => {
  client_socket.addEventListener('error', console.error);
  client_socket.addEventListener('message', (message) => {
    console.log('received: %s', message);
    client_socket.send('acknowledge msg : ' + message);
    notifyAll(message);
  });
  client_socket.addEventListener('close', (event) => {
    console.log('client disconnected ');
  });
})