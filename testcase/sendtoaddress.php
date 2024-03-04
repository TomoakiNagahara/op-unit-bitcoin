<?php
/** op-unit-bitcoin:/testcase/sendtoaddress.php
 *
 * @created    2021-01-02
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

/** use
 *
 */
use function OP\Unit;
use function OP\Request;

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

//	...
$request = Request();

//	...
$address = $request['address'] ?? null;
$amount  = $request['amount']  ?? null;

//	...
if( empty($address) and empty($amount) ){
	D("Empty address or amount", $request);
	return;
}

//	...
$transaction_id = $bitcoin->Send($address, $amount);

//	...
D($transaction_id);
