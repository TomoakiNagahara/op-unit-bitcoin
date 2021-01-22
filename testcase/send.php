<?php
/** op-unit-bitcoin:/testcase/send.php
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

//	...
if(!Env::isAdmin() ){
	throw new \Exception('You are not an administrator.');
}

//	...
$base_name = explode('.', basename(__FILE__))[0];

/* @var $form \OP\UNIT\Form */
$form = \OP\Unit('Form');
$form->Config("{$base_name}.form.php");

//	...
if( $form->isValidate() ){
	/* @var $bitcoin \OP\UNIT\Bitcoin */
	$bitcoin = Unit('Bitcoin');

	//	...
	$address = $form->GetValue('address');
	$amount  = $form->GetValue('amount' );
	$transaction_id = $bitcoin->Send($address, $amount);

	//	...
	if( $transaction_id ){
		$form->Clear('amount');
	}

	//	...
	$result = [];
	$result['Transaction ID']  = $transaction_id;
	$result['Bitcoin address'] = $address;
	$result['Bitcoin Amount']  = $amount;
	D($result);
}

//	...
echo $form;
