<?php
/** op-unit-bitcoin:/Bitcoin-RPC.class.php
 *
 * @created   2024-03-02
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
namespace OP\UNIT\BITCOIN;

/** Used class.
 *
 */
use OP\OP_CI;
use OP\OP_CORE;
use OP\OP_UNIT;
use OP\IF_UNIT;

/** Bitcoin-RPC
 *
 * @created   2024-03-02
 * @version   1.0
 * @package   op-unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class RPC implements IF_UNIT
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_UNIT, OP_CI;

	/** Stack values for CI.
	 *
	 * @created    2024-03-02
	 * @var        array
	 */
	static $_CI;

	/** construct
	 *
	 * @created    2024-03-02
	 */
	function __construct()
	{
		//	...
		if( Env::AppID() === _OP_UNIT_CI_APP_ID_ ){
			//	...
			self::$_CI['balance']['null']     = self::Balance();
			self::$_CI['balance']['testcase'] = self::Balance('testcase');
		}
	}

	/** Get RPC port number.
	 *
	 * @created  2019-08-28
	 * @param    string      $chain
	 * @return   integer     $port
	 */
	static function Port(string $label) : int
	{
		//	...
		switch( $label ){
			case 'mainnet':
				$port =  8332;
				break;
			case 'testnet':
				$port = 18332;
				break;
			case 'regtest':
				$port = 18443;
				break;
		};

		//	...
		return $port;
	}

	/** Submit to RPC.
	 *
	 * @created  2019-08-28
	 * @param    string      $method
	 * @return   string      $json
	 */
	static function RPC(string $method, $params=[])
	{
		//	...
		static $_url;

		//	...
		if( $_url === null ){
			//	...
			$config = OP()->Unit('Bitcoin')->Config();

			//	...
			if(!$config['RPC'] ?? null ){
				throw new \Exception("Config was empty. (asset:/config/bitcoin.php)");
			}

			//	...
			if(!$chain = $config['RPC']['chain'] ?? null ){
				throw new \Exception("Chain is not set in config.");
			}

			//	...
			$port = self::Port($chain);

			//	...
			if( $config['RPC']['host']     ?? null ){ $host = $config['RPC']['host'];     }
			if( $config['RPC']['user']     ?? null ){ $user = $config['RPC']['user'];     }
			if( $config['RPC']['password'] ?? null ){ $pass = $config['RPC']['password']; }

			//	...
			if( $config['bitcoin.conf']['general']['rpcuser']     ?? null ){ $user = $config['bitcoin.conf']['general']['rpcuser'];     }
			if( $config['bitcoin.conf']['general']['rpcpassword'] ?? null ){ $pass = $config['bitcoin.conf']['general']['rpcpassword']; }

			//	...
			$_url = "http://{$user}:{$pass}@{$host}:{$port}";
		};

		//	...
		$json = [];
		$json['jsonrpc'] = '1.0';
		$json['id']      = 'forasync';
		$json['method']  = $method;
		$json['params']  = $params;
		$json = json_encode($json);

		//	...
		$curl = "curl --data-binary '$json' -H 'content-type:text/plain;' $_url";
		$json = `$curl`;

		//	...
		if(!$json ){
			throw new \Exception("curl is return null. ($_url)");
		}

		//	...
		$json = json_decode($json, true);

		//	...
		if( $json['error']){
			$json['error']['method'] = $method;
			$json['error']['params'] = $params;
			throw new \Exception( json_encode($json['error']) );
		};

		//	...
		return $json['result'];
	}

	/** Get bitcoin address by label.
	 *
	 * @created  2019-08-28
	 * @param    string      $lable
	 * @return   string      $address
	 */
	static function Address($label=null, $purpose='receive')
	{
		//	...
		try{
			if( $label and $result = self::RPC('getaddressesbylabel',[$label]) ){
				//	...
				foreach( $result as $key => $val ){
					//	...
					if( $purpose and $purpose === $val['purpose']){
						return $key;
					};
				};

				//	...
				throw new \Exception("Does not match this purpose. ({$purpose})");
			};
		}catch( \Throwable $e ){
			//	...
			$text = $e->getMessage();
			if(!$json = json_decode($text, true) ){
				throw new \Exception($text);
			}

			//	...
			if( $json['code'] !== -11 ){
				throw $e;
			};
		};

		//	...
		return self::RPC('getnewaddress',[$label]);
	}

	/** Get balance
	 *
	 * @created  2019-08-28
	 * @param    string      $address
	 * @return   string      $address
	 */
	static function Balance($address=null)
	{
		//	...
		if( self::$_CI ){
			//	...
			if( $address ){
				$balance = self::$_CI['balance'][$address] ?? null;
			}else{
				$balance = self::$_CI['balance']['null'];
			}
			//	...
			return $balance;
		}

		//	...
		return self::RPC('getbalance',[$address]);
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
		return self::RPC('sendtoaddress',[$address, $amount]);
	}

	/** Received bitcoin.
	 *
	 * @created  2019-08-28
	 * @param    string      $address
	 * @return   integer     $result
	 */
	static function Recieved($address)
	{
		return self::RPC('getreceivedbyaddress',[$address]);
	}

	/** Received bitcoin.
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
	static function Block($block_id)
	{
		return self::RPC('getblock',[$block_id]);
	}

	/** Generate block.
	 *
	 * @created  2019-08-28
	 * @param    integer     $number of blocks
	 * @return   string      $address of mining reward
	 */
	static function Mining($number, $address)
	{
		//	...
		if( Env::AppID() === _OP_UNIT_CI_APP_ID_ ){
			return 'CI:block_id';
		}

		//	...
		return self::RPC('generatetoaddress',[1, $address]);
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
}
