<?php
/** op-unit-bitcoin:/testcase/address.php
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

//	...
$base_name = explode('.', basename(__FILE__))[0];

/* @var $form \OP\UNIT\Form */
$form = \OP\Unit('Form');
$form->Config("{$base_name}.form.php");

//	...
echo $form;

//	...
if(!$form->isValidate() ){
	return;
}

//	...
$label = $form->GetValue('label');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

//	...
$address = $bitcoin->Address($label);

//	...
D(['label'=>$label, 'address'=>$address]);
