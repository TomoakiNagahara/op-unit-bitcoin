<?php
/** op-unit-bitcoin:/testcase/balance.php
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
$address = $form->GetValue('address');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$balance = $bitcoin->Balance($address);

//	...
D(['balance'=>$balance, 'address'=>$address]);

//	...
D($bitcoin->RPC('listaddressgroupings'));
