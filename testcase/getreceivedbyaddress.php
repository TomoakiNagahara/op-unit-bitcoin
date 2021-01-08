<?php
/** op-unit-bitcoin:/testcase/getreceivedbyaddress.php
 *
 * @created   2021-01-07
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
use function OP\Template;

//	...
$address = Request('address');

//	...
Template('getreceivedbyaddress.phtml');

//	...
if(!$address ){
	throw new \Exception('Empty address.');
}

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$balance = $bitcoin->Received($address);

//	...
D(['balance'=>$balance, 'address'=>$address]);
