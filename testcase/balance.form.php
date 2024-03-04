<?php
/** op-unit-bitcoin:/testcase/balance.form.php
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
/*
$base58 = (Config::Get('bitcoin')['chain'] === 'mainnet') ? ',base58':'';
*/
$base58 = (Config::Get('bitcoin')['chain'] !== 'regtest') ? ',base58':'';

//	...
$name  = 'address';
$input = [];
$input['type']   =  'text';
$input['name']   = $name;
$input['rule']   = $base58;
$input['placeholder'] = 'Bitcoin address';
$form['input'][] = $input;

//	...
$name  = 'button';
$input = [];
$input['type']   = 'button';
$input['name']   = $name;
$input['value']  = 'Submit';
$form['input'][] = $input;

//	...
return $form;
