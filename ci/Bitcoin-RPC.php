<?php
/** op-unit-bitcoin:/ci/Bitcoin-RPC.php
 *
 * @created     2024-03-02
 * @version     1.0
 * @package     op-unit-bitcoin
 * @author      Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright   Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP;

/* @var $ci UNIT\CI */
$ci = OP::Unit('CI');

//	Template
$arg1   = 'foo';
$arg2   = 'bar';
$args   = ['ci.phtml',['arg1'=>$arg1, 'arg2'=>$arg2]];
$result = $arg1 . $arg2;
$ci->Set('Template', $result, $args);

//	Port - null
$args   =  null;
$result = 'Exception: OP\UNIT\Bitcoin\RPC::Port(): Argument #1 ($label) must be of type string, null given, called in /System/Volumes/Data/www/op/core/7/trait/OP_CI.php on line 53';
$ci->Set('Port', $result, $args);

//	Port - mainnet
$args   = 'mainnet';
$result =  8332;
$ci->Set('Port', $result, $args);

//	Port - testnet
$args   = 'testnet';
$result =  18332;
$ci->Set('Port', $result, $args);

//	Port - regtest
$args   = 'regtest';
$result =  18443;
$ci->Set('Port', $result, $args);

//	RPC - null
$args   =  null;
$result = 'Exception: OP\UNIT\Bitcoin\RPC::RPC(): Argument #1 ($method) must be of type string, null given, called in /System/Volumes/Data/www/op/core/7/trait/OP_CI.php on line 53';
$ci->Set('RPC', $result, $args);

//	...
return $ci->GenerateConfig();
