<?php
/** op-unit-bitcoin:/Database.class.php
 *
 * @created   2020-12-24
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT;

/** Used class.
 *
 */
use OP\Env;
use OP\OP_CORE;

/** Bitcoin
 *
 * @created   2020-12-24
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Database
{
	/** trait.
	 *
	 */
	use OP_CORE;

	/** Return Database Unit.
	 *
	 * @return \OP\UNIT\Database
	 */
	private function _Database()
	{
		/* @var $_database \OP\UNIT\Database */
		static $_database;

		//	...
		if(!$_database ){
			$_database = Unit('Database');
			$_database->Connect( Env::Get('bitcoin')['database'] ?? [] );

			//	...
			if(!$_database->isConnect() ){
				throw new \Exception("Database connection failed.");
			}
		}

		//	...
		return $_database;
	}

	/** Send amount to bitcoin address.
	 *
	 * @created   2020-12-24
	 * @param     string       $address
	 * @param     string       $amount
	 * @param     string       $transaction_id
	 */
	function Send($address, $amount, $transaction_id)
	{
		//	...
		$config = [];
		$config['table'] = 'op_btc_transaction';
		$config['set']['address']        = $address;
		$config['set']['amount']         = $amount;
		$config['set']['transaction_id'] = $transaction_id;

		//	...
		self::_Database()->Insert($config);
	}
}
