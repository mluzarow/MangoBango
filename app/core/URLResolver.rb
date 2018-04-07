# Extracts important information from the given URL, such as the page controller
# that will be used to render the target page as well as any additional variables
# passed via a query string.
class URLResolver
	# Constructor for class URLResolver. Extracts and sets URI segments and passed
	# query string variables.
	# 
	# @param [String] uri URL of loaded page minus the hostname
	def initialize(uri)
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
	end
	
	# Gets the list of URI segments split by '/'
	# 
	# @return [Array] list of URI segments
	def getSegment()
		@segments
	end
	
	# Gets the page class, or the final segment of the given URI.
	# 
	# @return [String] lowercase page controller class name
	def getPageClass()
		@segments[-1]
	end
	
	# Gets hash of query vars passed with the given URL.
	# 
	# @return [Hash] dict of query variables
	def getQueryVars()
		@query_vars
	end
end