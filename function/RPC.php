<?php
/** op-unit-bitcoin:/function/RPC.php
 *
 * @created    2024-03-05
 * @version    1.0
 * @package    op-unit-bitcoin
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN;

/** RPC
 *
 * @moved      2024-03-05  from Bitcoin::RPC()
 * @version    1.0
 * @package    op-unit-bitcoin
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */
function RPC(string $method, array $params=[])
{
	//	Bitcoin RPC URL
	static $_url;

	//	Bitcoin RPC URL - Build
	if( $_url === null ){
		//	...
		$config = OP()->Config('bitcoin');
		//	...
		$port = $config['port']     ?? \OP\UNIT\BITCOIN::Port($config['chain']);
		$host = $config['host']     ?? null;
		$user = $config['user']     ?? null;
		$pass = $config['password'] ?? null;
		//	...
		$_url = "http://{$user}:{$pass}@{$host}:{$port}";
	};

	//	Bitcoin RPC JSON - Build
	$json = [];
	$json['jsonrpc'] = '1.0';
	$json['id']      = 'forasync';
	$json['method']  = $method;
	$json['params']  = $params;
	$json = json_encode($json);

	/*
	 //	Console command.
	 $command = "curl --data-binary '$json' -H 'content-type:text/plain;' $_url";
	 $json = `$curl`;
	 */

	//	Curl - Header
	$headers = array(
		"Content-Type: application/json",
	);

	//	Check
	if(!function_exists('curl_init') ){
		$module = 'curl';
		include( ConvertPath('asset:/bootstrap/php/content.phtml') );
		throw new \Exception("php-{$module} is not installed.");
	}

	//	Curl - Setting
	$curl = curl_init($_url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST  , "POST"   );
	curl_setopt($curl, CURLOPT_POSTFIELDS     , $json    );
	curl_setopt($curl, CURLOPT_RETURNTRANSFER ,  TRUE    );
	curl_setopt($curl, CURLOPT_HTTPHEADER     , $headers );
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER ,  FALSE   );
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST ,  FALSE   );
	curl_setopt($curl, CURLOPT_COOKIEJAR      , 'cookie' );
	curl_setopt($curl, CURLOPT_COOKIEFILE     , '/tmp'    );
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION ,  TRUE    );

	//	Curl - Execute
	$json = curl_exec($curl);
	curl_close($curl);

	//	JSON - Parse
	$json = json_decode($json, true);

	//	...
	if( $json['error'] ?? null ){
		throw new \Exception( json_encode($json['error']) );
	};

	return $json['result'] ?? null;
}
