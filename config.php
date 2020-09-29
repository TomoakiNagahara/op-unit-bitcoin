<?php
/** op-unit-bitcoin:/config.php
 *
 * @creation  2020-09-29
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

//	...
switch( $_SERVER['SERVER_NAME'] ){
	//	Production
	case 'example.com':
		$network = 'mainnet';
		break;

	//	Staging
	case 'sta.example.com':
		$network = 'mainnet';
		break;

	//	Test
	case 'tst.example.com':
		$network = 'testnet';
		break;

	//	Develop
	case 'dev.example.com':
		$network = 'regtest';
		break;

	default:
	//	Notice::Set("This domain name is undefined. ({$_SERVER['SERVER_NAME']})");
		$network = 'regtest';
	break;
}

//	...
switch( $network ){
	case 'mainnet':
		$chain    = 'mainnet';
		$host     = '127.0.0.1';
		$user     = 'u';
		$password = 'p';
		break;

	case 'testnet':
		$chain    = 'testnet';
		$host     = '127.0.0.1';
		$user     = 'u';
		$password = 'p';
		break;

	case 'regtest':
		$chain    = 'regtest';
		$host     = '127.0.0.1';
		$user     = 'u';
		$password = 'p';
		break;

	default:
}

//	...
$config = [
	'chain'     => $chain,
	'host'      => $host,
	'user'      => $user,
	'password'  => $password,
//	'port'      => $port ?? null,
];

//	...
return $config;
