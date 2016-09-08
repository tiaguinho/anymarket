<?php 

class Anymarket {

	const VERSION = "1.0";

	const URL_API = "http://api.anymarket.com.br/v2";
	const URL_SANDBOX = "http://sandbox-api.anymarket.com.br/v2";

	/**
	 * @access protected
	 */
		protected $token;
		protected $sandbox;

	/**
     * Configuration for CURL
     */
	    public static $CURL_OPTS = [
	        CURLOPT_USERAGENT => "ANYMARKET-PHP-SDK-1.0", 
	        CURLOPT_SSL_VERIFYPEER => true,
	        CURLOPT_CONNECTTIMEOUT => 10, 
	        CURLOPT_RETURNTRANSFER => 1, 
	        CURLOPT_TIMEOUT => 60
	    ];

	/**
	 * Construct method
	 * 
	 * @param string $token
	 * @access public
	 * @return void
	 */
		public function __construct($token, $sandbox = true) {
			$this->token = $token;
			$this->sandbox = $sandbox;
		}

	/**
	 * Execute a GET request
	 * 
	 * @param string $path
	 * @param array $params
	 * @return mixed
	 */
		public function get($path, $params = null, $assoc = false) {
			return $this->execute($path, null, $params, $assoc);
		}

	/**
	 * Execute a POST request
	 * 
	 * @param string $path
	 * @param array $body
	 * @param array $params
	 * @return mixed
	 */
		public function post($path, $body = null, $params = []) {
			$opts = [
	            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
	            CURLOPT_POST => true, 
	            CURLOPT_POSTFIELDS => json_encode($body)
	        ];

	        return $this->execute($path, $opts, $params);
		}

	/**
	 * Execute a PUT request
	 * 
	 * @param string $path
	 * @param array $body
	 * @param array $params
	 * @return mixed
	 */
		public function put($path, $body = null, $params = []) {
			$opts = [
	            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
	            CURLOPT_CUSTOMREQUEST => "PUT",
	            CURLOPT_POSTFIELDS => json_encode($body)
	        ];

	        return $this->execute($path, $opts, $params);
		}

	/**
	 * Execute a DELETE request
	 * 
	 * @param string $path
	 * @param array $params
	 * @return mixed
	 */
		public function delete($path, $params) {
			$opts = [CURLOPT_CUSTOMREQUEST => "DELETE"];

			return $this->execute($path, $opts, $params);
		}

	/**
	 * Get the URL where the request will be sended
	 * 
	 * @param string $path
	 * @param array $params
	 * @return string $uri
	 * @access protected
	 */
		protected function getURL($path, $params = []) {
			$uri = ($this->sandbox ? self::URL_SANDBOX : self::URL_API);
			if (!preg_match("/^http/", $path)) {
	            if (!preg_match("/^\//", $path)) {
	                $path = '/'.$path;
	            }
	        }
	 
	        $uri .= $path . '?gumgaToken=' . $this->token;

	        if(!empty($params)) {
	            $paramsJoined = array();
	            foreach($params as $param => $value) {
	               $paramsJoined[] = "$param=$value";
	            }

	            $uri .= implode('&', $paramsJoined);
	        }

	        return $uri;
		}

	/**
	 * Execute the requests and return de json body and headers
	 * 
	 * @param string $path
	 * @param array $opts
	 * @param array $params
	 * @return mixed
	 */
		public function execute($path, $opts, $params, $assoc = false) {
			$uri = $this->getURL($path, $params);

			$ch = curl_init($uri);
        	curl_setopt_array($ch, self::$CURL_OPTS);
        	if(!empty($opts))
            	curl_setopt_array($ch, $opts);

        	$return["body"] = json_decode(curl_exec($ch), $assoc);
        	$return["httpCode"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        	curl_close($ch);
        
        	return $return;
		}

}