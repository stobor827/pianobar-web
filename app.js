var i = 0;

var finalhandler = require('finalhandler');
var http = require('http');
var io = require('socket.io');
var fs = require('fs');
var serveStatic = require('serve-static');



var serve = serveStatic('site');

var server = http.createServer( function onRequest(req,res){
  serve(req,res,finalhandler(req,res));
})
io = io.listen(server);
server.listen(8006);
console.log("start");  
io.sockets.on('connection', function (socket) {
  console.log("connected");

  //read stationlist and send it to client.



  fs.watch( '/var/www/html/pianobar/pb.html',
  function( ev, file){
        var str = fs.readFileSync( '/var/www/html/pianobar/pb.html', 'utf8');
        if( str == "" ){
          return;
        }
        //console.log( str );
        socket.emit( 'date',
          {date: str}
        )
      }
    );
  socket.on("play",function (socket){
    console.log("play");
  });
  socket.on("next",function (socket){
    console.log("next");
  });
});

