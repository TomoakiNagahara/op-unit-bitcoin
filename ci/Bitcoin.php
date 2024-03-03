<?php
/** op-unit-bitcoin:/ci/Bitcoin.php
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

//	CLI
$args   =  null;
$result = 'OP\UNIT\Bitcoin\CLI';
$ci->Set('CLI', $result, $args);

//	RPC
$args   =  null;
$result = 'OP\UNIT\Bitcoin\RPC';
$ci->Set('RPC', $result, $args);

//	...
return $ci->GenerateConfig();
