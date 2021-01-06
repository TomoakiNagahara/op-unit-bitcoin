<?php
/** op-unit-bitcoin:/testcase/mining.php
 *
 * @created   2021-01-06
 * @package   op-unit-bitcoin
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN;

/** use
 *
 */
use function OP\Unit;
use function OP\Request;

//	...
$address = Request('address');
$block   = Request('block', 1);

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$result = $bitcoin->Mining($address, $block);

//	...
D(['address'=>$address, 'block'=>$block, 'result'=>$result]);
