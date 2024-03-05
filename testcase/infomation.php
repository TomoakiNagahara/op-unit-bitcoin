<?php
/** op-unit-bitcoin:/testcase/information.php
 *
 * @created   2024-03-06
 * @package   op-unit-bitcoin
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN;

//	...
$chain = OP()->Config('bitcoin')['chain'] ?? null;
$port  = OP()->Unit('Bitcoin')->Port($chain);

//	...
$info['chain'] = $chain;
$info['port']  = $port;

//	...
D($info);
