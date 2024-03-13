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

	/** CLI - Access to local process.
	 *
	 * @created   2024-03-02
	 * @return    BITCOIN\CLI
	 */
	static function CLI() : BITCOIN\CLI
	{
		//	...
		static $_CLI;

		//	...
		if(!$_CLI ){
			require_once(__DIR__.'/Bitcoin-CLI.class.php');
			$_CLI = new BITCOIN\CLI;
		}

		//	...
		return $_CLI;
	}

	/** RPC - Access by TCP/IP
	 *
	 * @created   2024-03-02
	 * @return    Bitcoin\RPC
	 */
	static function RPC() : Bitcoin\RPC
	{
		//	...
		static $_RPC;

		//	...
		if(!$_RPC ){
			require_once(__DIR__.'/Bitcoin-RPC.class.php');
			$_RPC = new Bitcoin\RPC;
		}

		//	...
		return $_RPC;
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
