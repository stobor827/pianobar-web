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

function sendCurrentlyPlaying(socket){
  var str = fs.readFileSync( 'pb.html', 'utf8');
  if( str == "" ){
    return;
  }
  //console.log( str );
  socket.emit( 'date',
    {date: str}
  )
}

io.sockets.on('connection', function (socket) {
  console.log("connected");

  //read stationlist and send it to client.
  var stationList = fs.readFileSync('pblist.html', 'utf8');
  if( stationList != ""){
    socket.emit('stations', {content:stationList});
  }
  sendCurrentlyPlaying(socket);
  fs.watch( 'pb.html', sendCurrentlyPlaying(socket) );

  socket.on("play",function (data){
    console.log("play");
  });
  socket.on("next",function (data){
    console.log("next");
  });
  socket.on("changeStation", function( data){
    console.log("changeStation", data.station);
  })
});

