# Extracts important information from the given URL, such as the page controller
# that will be used to render the target page as well as any additional variables
# passed via a query string.
class URLResolver
	# Constructor for class URLResolver. Extracts and sets URI segments and passed
	# query string variables.
	# 
	# @param [String] uri URL of loaded page minus the hostname
	def initialize(uri)
		@query_var = []
		@segments = []
		@file_contents = ''
		@class_name = ''
		
		uri[0] = ''
		
		query_segment = uri.split('?')
		
		if (query_segment.size < 2)
			@query_var = []
		else
			query_strings = query_segment[1].split('&')
			
			query_vars = {}
			for var in query_strings
				single_var = var.split('=')
				
				query_vars[single_var[0]] = single_var[1]
			end
			@query_vars = query_vars
		end
		
		@segments = uri.split('/')
		
		if (@segments[0] == 'resources')
			# A resource was requested instead of a controller
			filepath = File.join(File.dirname(__FILE__), "../#{uri}")
			@file_contents = File.binread(filepath)
		else
			@class_name = @segments[-1]
		end
	end
	
	# Gets the list of URI segments split by '/'
	# 
	# @return [Array] list of URI segments
	def getSegment()
		@segments
	end
	
	def getFileContents()
		@file_contents
	end
	
	# Gets the page class, or the final segment of the given URI.
	# 
	# @return [String] lowercase page controller class name
	def getPageClass()
		@class_name
	end
	
	# Gets hash of query vars passed with the given URL.
	# 
	# @return [Hash] dict of query variables
	def getQueryVars()
		@query_vars
	end
end