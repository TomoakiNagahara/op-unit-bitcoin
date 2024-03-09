<?php
/** op-unit-bitcoin:/testcase/all.php
 *
 * @created   2024-03-09
 * @version   1.0
 * @package   op-unit-bitcoin
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

/** use
 *
 */

/* @var $form \OP\UNIT\Form */
$form = OP()->Unit('Form');
$form->Config('All.form.php');

//	Validate
$form->Validate();

//	Display
echo $form;

//	...
if(!$form->isValidate() ){
	//	NG
	return;
}

//	Request
$values = $form->Values();
$label  = $values['label'];
$amount = $values['amount'];

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = OP()->Unit('Bitcoin');

//	Get bitcoin address by label
$values['address'] = $address = $bitcoin->Address($label);

//	Send to bitcoin by address
$values['transaction_id'] = $transaction_id = $bitcoin->Send($address, $amount);

//	Get transaction before
$values['transaction_1'] = $bitcoin->Transaction($transaction_id);

//	Mining
if( $testcase = $bitcoin->Address('testcase') ){
	if( $values['mining']['block']['id'] = $block_id = $bitcoin->Mining($testcase)[0] ){
		//	Get block info
		$values['mining']['block']['info'] = $bitcoin->InfoBlock($block_id);

		//	Get transaction after
		$values['transaction_2'] = $bitcoin->Transaction($transaction_id);

		//	Address info
		$values['info'][$label]     = $bitcoin->InfoAddress($address);
		$values['info']['testcase'] = $bitcoin->InfoAddress($testcase);
	}
}

//	Get balance
$values['balance']['wallet']   = $bitcoin->Balance();
$values['balance'][$label]     = $bitcoin->Received($address);
$values['balance']['testcase'] = $bitcoin->Received($testcase);

//	...
unset($values['button']);
D($values);
