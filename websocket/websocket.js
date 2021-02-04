var app = require("express")();
var bodyParser = require("body-parser");
app.use(bodyParser.urlencoded({
	extended: false
}));
app.use(bodyParser.json());
var server = require("http").Server(app);
var io = require("socket.io")(server);


io.origins((origin, callback) => {
	callback(null, true);
});
var port = 1010;

server.listen(process.env.PORT || port, '0.0.0.0', function () {
	console.log('listening on *:' + port);
});
// WARNING: app.listen(80) will NOT work here!
// konversi dari rest do\i broadcast ke socketio
// app.post("/test", function (req, res) {
// 	console.log('triggered');
// 	// console.log(req.body);
// 	io.emit("test-listen", req.body);
// 	res.send("TEST OK");
// });
 



io.on("connection", function (socket) 
{
	socket.on('realtime', (data) => {
		console.log(data);
		io.emit("realtime", data);
	});
	socket.join("all");
	// socket.join("all");
	// socket.emit('news', {
	// 	hello: 'world'
	// });
	// socket.on('my other event', function (data) {
	// 	console.log(data);
	// });
});