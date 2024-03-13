<?php
/** op-unit-bitcoin:/Bitcoin.class.php
 *
 * @created   2019-08-27
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
namespace OP\UNIT;

/** Used class.
 *
 */
use OP\OP_CI;
use OP\OP_CORE;
use OP\OP_UNIT;
use OP\IF_UNIT;
use function OP\ConvertPath;

/** Bitcoin
 *
 * @created   2019-08-27
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Bitcoin implements IF_UNIT
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_UNIT, OP_CI;

	/** Database
	 *
	 */
	static function Database()
	{
		/* @var $_database BITCOIN\Database */
		static $_database;

		//	...
		if( $_database === null ){
			//	...
			require(__DIR__.'/Database.class.php');

			//	...
			$_database = new \OP\UNIT\BITCOIN\Database();
		}

		//	...
		return $_database;
	}

	/** Get bitcoin address by label.
	 *
	 * <pre>
	 * //  Get bitcoin address.
	 * $this->Address();
	 *
	 * //  Get bitcoin address by label.
	 * $this->Address('TEST');
	 *
	 * //  Get new address generate always.
	 * $this->Address('TEST', null);
	 * </pre>
	 *
	 * @created  2019-08-28
	 * @param    string      $lable
	 * @param    string      $purpose
	 * @return   string      $address
	 */
	static function Address($label=null, $purpose='receive')
	{
		require_once(__DIR__.'/function/RPC/Address.php');
		return BITCOIN\RPC\Address($label, $purpose);
	}

	/** Get wallet balance. That total each address.
	 *
	 * @created  2019-08-28
	 * @param    string      $address
	 * @return   integer     $btc
	 */
	static function Balance(string $address='')
	{
		//	Per address.
		if( $address ){
			return self::Received($address);
		}

		//	Wallet total amount
		return self::RPC('getbalance');
	}

	/** Amount(string|null $address) --> Balance(null), Recieve(string $address)
	 *
	 * @created  2019-08-28
	 * @param    string|null $address
	 * @return   integer     $result
	 */
	static function Amount($address=null)
	{
		if( $address ){
			return self::Received($address);
		}else{
			return self::Balance();
		};
	}

	/** Send bitcoin.
	 *
	 * @created  2019-08-28
	 * @param    string      $address
	 * @param    float       $amount
	 * @return   string      $transaction_id
	 */
	static function Send($address, $amount)
	{
		//	...
		$transaction_id = self::RPC('sendtoaddress',[$address, $amount]);

		//	...
		if( OP()->Config('bitcoin')['database'] ?? null ){
			self::Database()->Send($address, $amount, $transaction_id);
		}

		//	...
		return $transaction_id;
	}

	/** Received is balance per address.
	 *
	 * @created  2019-08-28
	 * @param    string      $address
	 * @return   integer     $result
	 */
	static function Received(string $address)
	{
		return self::RPC('getreceivedbyaddress',[$address]);
	}

	/** Get transaction by id.
	 *
	 * @created  2019-08-28
	 * @param    string      $transaction_id
	 * @return   integer     $result
	 */
	static function Transaction($transaction_id)
	{
		return self::RPC('gettransaction',[$transaction_id]);
	}

	/** Get block information.
	 *
	 * @created  2019-08-28
	 * @param    string      $block_id
	 * @return   array       $result
	 */
	static function InfoBlock($block_id)
	{
		return self::RPC('getblock',[$block_id]);
	}

	/** Generate block.
	 *
	 * @created  2019-08-28
	 * @param    string      $address of receive reward
	 * @param    integer     $number of blocks
	 * @return   string      $address of mining reward
	 */
	static function Mining(string $address, int $number=1)
	{
		return self::RPC('generatetoaddress',[(int)$number, $address]);
	}

	/** Get Blockchain information.
	 *
	 * @created  2019-08-28
	 * @return   array
	 */
	static function InfoBlockchain()
	{
		return self::RPC('getblockchaininfo');
	}

	/** Get mining information.
	 *
	 * @created  2019-08-28
	 * @return   array
	 */
	static function InfoMining()
	{
		return self::RPC('getmininginfo');
	}

	/** Get wallet information.
	 *
	 * @created  2019-08-28
	 * @return   array
	 */
	static function InfoWallet()
	{
		return self::RPC('getwalletinfo');
	}

	/** Get address information.
	 *
	 * @created  2019-08-28
	 * @return   array
	 */
	static function InfoAddress($address)
	{
		return self::RPC('getaddressinfo', [$address]);
	}

	/** Return the config that also include the bitcoin.conf.
	 *
	 * @created   2024-03-02
	 * @return    array
	 */
	static function Config() : array
	{
		//	...
		static $config;

		//	...
		if(!$config ){
			$config = require_once(__DIR__.'/include/config.php');
		}

		//	...
		return $config;
	}
}
