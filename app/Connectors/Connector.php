<?php
namespace Connectors;

class Connector {
	/**
	 * Performs a cURL GET request with the constructed URL.
	 * 
	 * @param string $url constructed URL to be used
	 * 
	 * @return string JSON response from the MCD servers
	 */
	protected final function requestGET ($url) {
		$curl = curl_init ();
		
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec ($curl);
		
		curl_close ($curl);
		
		return ($response);
	}
	
	/**
	 * Performs a cURL POST request with the constructed URL & included POST
	 * variables.
	 * 
	 * @param string $url       constructed URL to be used
	 * @param array  $post_vars variables to be sent via POST
	 * 
	 * @return string JSON response from the MCD servers
	 */
	protected final function requestPOST ($url, $post_vars) {
		$curl = curl_init ();
		
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $post_vars);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$response = curl_exec ($curl);
		$error = curl_error ($curl);
		$errno = curl_errno ($curl);
		
		curl_close ($curl);
		
		return ($response);
	}
}
