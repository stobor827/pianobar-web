var i = 0;
var app = require('http').createServer(handler)
  , io = require('socket.io').listen(app)
    , fs = require('fs')
    
//    io.set( "transports", ["xhr-polling", "jsonp-polling"] );
    app.listen(8005);
    
    function handler (req, res) {
      fs.readFile(__dirname + '/index.html',
      function (err, data) {
       if (err) {
          res.writeHead(500);
          return res.end('Error loading index.html');
       }
                            
       res.writeHead(200);
       res.end(data);
      });
    }
  
//      io.of( '/node').on('connection', function(socket) {                                    
    io.sockets.on('connection', function (socket) {
//        socket.emit('news', { hello: 'world' });
/*        socket.on('my other event', function (data) {
            console.log(data);
        });
*/
//       setInterval( function(){ socket.emit( 'date', {date: i++} ) }, 100  );
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
    });