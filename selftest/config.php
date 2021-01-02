<?php
/** op-unit-bitcoin:/selftest/config.php
 *
 * @created   2021-01-02
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
$config = Config::Get('bitcoin')['database'];

//	...
$prod = $config['prod'];
$host = $config['host'];
$port = $config['port'];
$user = $config['user'];
$pass = $config['password'];
$char = $config['charset'];
$database = $config['name'];
$collate = null;

//  Instantiate self-test configuration generator.
$configer = \OP\UNIT\Selftest::Configer();

//  DSN configuration.
$configer->DSN([
	'host'     => $host,
	'product'  => $prod,
	'port'     => $port,
]);

//  User configuration.
$configer->User([
	'host'     => $host,
	'name'     => $user,
	'password' => $pass,
	'charset'  => $char,
]);

//  Database configuration.
$configer->Database([
	'name'     => $database,
	'charset'  => $char,
	'collate'  => $collate,
]);

//  Privilege configuration.
$configer->Privilege([
	'user'     => $user,
	'database' => $database,
	'table'    => '*',
	'privilege'=> 'insert, select, update, delete',
	'column'   => '*',
]);

//  Return selftest configuration.
return $configer->Get();
