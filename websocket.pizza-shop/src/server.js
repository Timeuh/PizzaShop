import http from 'node:http';

const reqHandler = async (req, res) => {
  res.writeHead(200);
  res.end({
    response: "success"
  });
}
const server = http.createServer(reqHandler);
server.listen(3000, 'localhost', () => {
  console.log('node: http://localhost:3000');
});
