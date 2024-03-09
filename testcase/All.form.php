<?php
/** op-unit-bitcoin:/testcase/send.form.php
 *
 * @created   2021-01-22
 * @package   op-unit-bitcoin
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

//	...
$form = [];
$form['name'] = substr(md5(__FILE__), 0, 8);

//	...
$name  = 'label';
$input = [
	'name'   => $name,
	'type'   => 'text',
	'rule'   => 'required',
	'cookie' => true,
	'placeholder' => 'Label of bitcoin address',
];
$form['input'][$name] = $input;

//	...
$name  = 'amount';
$input = [
	'name'   => $name,
	'type' => 'text',
	'rule' => 'required, number',
	'placeholder' => 'Send BTC amount',
];
$form['input'][$name] = $input;

//	...
$name  = 'button';
$input = [
	'name'   => $name,
	'type'  => 'button',
	'value' => 'Submit',
];
$form['input'][$name] = $input;

//	...
return $form;
