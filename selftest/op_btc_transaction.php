<?php
/** op-unit-bitcoin:/selftest/op_btc_transaction.php
 *
 * @created   2021-01-02
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP;

/* @var $configer \OP\UNIT\SELFTEST\Configer  */

//  ...
$configer->Set('table', [
	'name'    => 'op_btc_transaction',
	'comment' => 'Save bitcoin transaction id.',
]);

//  ...
$configer->Column( 'ai'            , 'int'      ,   11, false, null , 'Auto increment id.',['unsigned'=>true]);
$configer->Column( 'address'       , 'varchar'  ,   64, false, null , 'Bitcoin address.'  );
$configer->Column( 'amount'        , 'varchar'  ,   12, false, null , 'Send amount.'      );
$configer->Column( 'transaction_id', 'varchar'  ,   64,  true, null , 'Transaction ID.'   );
$configer->Column( 'created'       , 'datetime' , null, false, null , 'Created date time.');
$configer->Column( 'timestamp'     , 'timestamp', null, false, null , 'Timestamp.'        );

//	...
$configer->Index('PRIMARY'       ,      'ai',             'ai', 'Auto increment id.');
$configer->Index('transaction_id',  'unique', 'transaction_id', 'transaction_id'    );
