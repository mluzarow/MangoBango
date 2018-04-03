require 'socket'
require 'uri'

server = TCPServer.new('localhost', 5678)

loop do
	socket = server.accept
	request_line = socket.gets
	
	STDERR.puts request_line
	
	# Get URI segments
	path = (request_line.split ' ')[1]
	uri_segments = (path.split '/')[1..-1]
	
	response =
		"request_line #{request_line}" +
		"path #{path}\n" +
		"uri_segment #{uri_segments}\n"
	
	socket.print
		"HTTP/1.1 200 OK\n" +
		"Content-Type: text/plain\n" +
		"Content-Length: #{response.size}\n" +
		"Connection: close\n\n"
	
	socket.print response
	
	socket.close
end