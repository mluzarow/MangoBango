require 'socket'
require 'uri'
require_relative 'core/URLResolver'
require_relative 'pages/controllers/LibraryPage'
require_relative 'pages/views/LibraryPageView'

server = TCPServer.new('localhost', 5678)

loop do
	socket = server.accept
	request_line = socket.gets
	
	puts "Request: #{request_line}"
	
	# Get URI segments
	if (request_line.empty?)
		url_resolver = URLResolver.new('')
	else
		path = (request_line.split ' ')[1]
		url_resolver = URLResolver.new(path)
	end
	
	puts "Segs : #{url_resolver.getSegment}"
	
	if (!url_resolver.getFileContents.empty?)
		response = url_resolver.getFileContents
		content_type = "img/jpeg"
	else
		page_class = url_resolver.getPageClass()
		query_vars = url_resolver.getQueryVars()
		content_type = "text/html"
		
		response = LibraryPage.new.render()
	end
	
	socket.print "HTTP/2.0 200/OK\r\ncontent-type: #{content_type}\r\ncontent-length: #{response.size}\r\nconnection: close\r\n\r\n"
	
	socket.print response
	
	socket.close
end