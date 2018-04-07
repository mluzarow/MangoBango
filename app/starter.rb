require 'socket'
require 'uri'
require_relative 'core/URLResolver'

server = TCPServer.new('localhost', 5678)

loop do
	socket = server.accept
	request_line = socket.gets
	
	STDERR.puts request_line
	
	# Get URI segments
	path = (request_line.split ' ')[1]
	url_resolver = URLResolver.new(path)
	page_class = url_resolver.getPageClass()
	query_vars = url_resolver.getQueryVars()
	
	response =
		"request_line #{request_line}" +
		"path #{path}\n" +
		"page class #{page_class}\n" + 
		"vars #{query_vars}\n"
	
	socket.print
		"HTTP/1.1 200 OK\n" +
		"Content-Type: text/plain\n" +
		"Content-Length: #{response.size}\n" +
		"Connection: close\n\n"
	
	socket.print response
	
	socket.close
end