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
	$block   = $form->GetValue('block'  );
	$result  = $bitcoin->Mining($address, $block);

	//	...
	if( $result ){
		$form->Clear('block');
	}

	//	...
	D(['address'=>$address, 'block'=>$block, 'result'=>$result]);
}

//	...
echo $form;
