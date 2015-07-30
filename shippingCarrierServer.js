var http = require('http');

var server = http.createServer(function(request, response) {
	switch (request.url) {
		case '/':
			if (request.method === 'POST') {
				var data = '';
				request.on('data', function(chunk) {
					data += chunk;
				});

				request.on('end', function() {
					try {
						var params = JSON.parse(data);
						var obj = {};
						 if (typeof params.totalWeight === 'undefined') {
							throw 'Data parameter <em>totalWeight</em> was not provided.';
						} else if (isNaN(params.totalWeight)) {
							throw 'Data parameter <em>totalWeight</em> provided (' + params.totalWeight + ') is not a valid number.';
						}
						obj.rate = parseInt(params.totalWeight, 10) * 10;

						console.log('[200] ' + request.method + ' to ' + request.url);
						response.writeHead(200, {'Content-Type': 'application/json'});
						response.end(JSON.stringify(obj));
					} catch (error) {
						console.log('[500] ' + request.method + ' to ' + request.url);
						response.writeHead(500, 'Internal server error', {'Content-Type': 'text/html'});
						response.end('<html><head><title>500 - Internal Server Error</title></head><body><h1>Internal server error.</h1><p>' +
							error + '</p></body></html>');
					}
				});
			} else {
				console.log('[405] ' + request.method + ' to ' + request.url);
				response.writeHead(405, 'Method not supported', {'Content-Type': 'text/html'});
				response.end();
			}

			break;
		default:
			console.log('[404] ' + request.method + ' to ' + request.url);
			response.writeHead(404, 'Not found', {'Content-Type': 'text/html'});
			response.end('<html><head><title>404 - Not Found</title></head><body><h1>Not found.</h1></body></html>');
	}
}).listen('3000', 'localhost');
console.log('Server running at http://localhost:3000/');
