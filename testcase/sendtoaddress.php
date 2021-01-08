<?php
/** op-unit-bitcoin:/testcase/sendtoaddress.php
 *
 * @created   2020-12-25
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
use OP\Env;
use function OP\Unit;
use function OP\Request;

//	...
if(!Env::isAdmin() ){
	throw new \Exception('You are not an administrator.');
}

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

//	...
$request = Request();

//	...
$address = $request['address'] ?? null;
$amount  = $request['amount']  ?? null;

//	...
if( empty($address) or empty($amount) ){
	D("Empty address or amount", $request);
	return;
}

//	...
$transaction_id = $bitcoin->Send($address, $amount);

//	...
D($transaction_id);
