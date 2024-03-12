<?php
/** op-unit-bitcoin:/ci/Bitcoin-RPC.php
 *
 * @created     2024-03-02
 * @version     1.0
 * @package     op-unit-bitcoin
 * @author      Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright   Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP;

/* @var $match array */
/* @var $ci UNIT\CI */
$ci = OP::Unit('CI');

//	Template
$arg1   = 'foo';
$arg2   = 'bar';
$args   = ['ci.phtml',['arg1'=>$arg1, 'arg2'=>$arg2]];
$result = $arg1 . $arg2;
$ci->Set('Template', $result, $args);

//	Port - null
$args   =  null;
$result = 'Exception: OP\UNIT\Bitcoin\RPC::Port(): Argument #1 ($label) must be of type string, null given, called in /System/Volumes/Data/www/op/core/7/trait/OP_CI.php on line 53';
$ci->Set('Port', $result, $args);

//	Port - mainnet
$args   = 'mainnet';
$result =  8332;
$ci->Set('Port', $result, $args);

//	Port - testnet
$args   = 'testnet';
$result =  18332;
$ci->Set('Port', $result, $args);

//	Port - regtest
$args   = 'regtest';
$result =  18443;
$ci->Set('Port', $result, $args);

//	RPC - null
$args   =  null;
$result = 'Exception: OP\UNIT\Bitcoin\RPC::RPC(): Argument #1 ($method) must be of type string, null given, called in /System/Volumes/Data/www/op/core/7/trait/OP_CI.php on line 53';
$ci->Set('RPC', $result, $args);

/** Bitcoin-cli
 * @see https://qiita.com/daiki44/items/cf6ba7ae9572f34d8b52
 */
$bitcoin_config = OP()->Config('bitcoin');
$bitcoin_path   = trim(`which bitcoin-cli`);
$bitcoin_conf   = $bitcoin_config['bitcoin.conf'];
$bitcoin_chain  = $bitcoin_config['chain'];
$bitcoin_cli    = "{$bitcoin_path} -conf={$bitcoin_conf} -{$bitcoin_chain}";

//	...
if( $bitcoin_chain !== 'regtest' ){
	throw new \Exception("A network chain is not regtest. ($bitcoin_chain)");
}

//	Address
$label  = 'testcase';
$json   = trim(`{$bitcoin_cli} getaddressesbylabel {$label}`);
if( preg_match('|\s"([a-z0-9]{44})": {\n|', $json, $match) ){
	$address = $match[1];
}else{
	throw new \Exception($json);
}
$args   = $label;
$result = $address;
$ci->Set('Address', $result, $args);

//	Balance (total)
$args   = null;
$result = (float)trim(`{$bitcoin_cli} getbalance`);
$ci->Set('Balance', $result, $args);

//	Balance (each address)
$args   = $address;
$result = (float)trim(`{$bitcoin_cli} getbalance {$address}`);
$ci->Set('Balance', $result, $args);

//	Send
$amount = 1;
$args   = [$address, $amount];
$result = 'CI:transaction_id';
$ci->Set('Send', $result, $args);

//	Mining
$block_num = 1;
$args   = [$block_num, $address];
$result = 'CI:block_id';
$ci->Set('Mining', $result, $args);

//	Block
$json   = trim(`{$bitcoin_cli} generatetoaddress 1 {$address}`);
if( preg_match('|\s"([a-z0-9]{64})"\n|', $json, $match) ){
	$block_id = $match[1];
}
$args   = $block_id;
$result = trim(`{$bitcoin_cli} getblock {$block_id}`);
$ci->Set('Block', $result, $args);

//	Recieved
$args   = $address;
$result = (float)trim(`{$bitcoin_cli} getreceivedbyaddress {$address}`);
$ci->Set('Recieved', $result, $args);

//	Transaction
$transaction_id = trim(`{$bitcoin_cli} sendtoaddress {$address} {$amount}`);
$transaction    = trim(`{$bitcoin_cli} gettransaction {$transaction_id}`);
$transaction    = json_decode($transaction, true);
$args   = $transaction_id;
$result = $transaction;
$ci->Set('Transaction', $result, $args);

//	...
return $ci->GenerateConfig();
