<?php
/**
 * unit-bitcoin:/Bitcoin.class.php
 *
 * @creation  2019-08-27
 * @version   1.0
 * @package   unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 * @creation  2019-08-27
 */
namespace OP\UNIT;

/** Used class.
 *
 * @creation  2019-08-27
 */
use OP\Env;
use OP\OP_CORE;
use OP\OP_UNIT;
use OP\IF_UNIT;

/** Bitcoin
 *
 * @creation  2019-08-27
 * @version   1.0
 * @package   unit-bitcoin
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */
class Bitcoin implements IF_UNIT
{
	/** trait.
	 *
	 */
	use OP_CORE, OP_UNIT;

	/** Get RPC port number.
	 *
	 * @created  2019-08-28
	 * @param    string      $chain
	 * @return   integer     $port
	 */
	static function Port($label)
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
	static function RPC($method, $params=[])
	{
		//	...
		static $_url;

		//	...
		if( $_url === null ){
			//	...
			$config = Env::Get('bitcoin');
			//	...
			$port = self::Port($config['chain']);
			$host = $config['host']     ?? null;
			$user = $config['user']     ?? null;
			$pass = $config['password'] ?? null;
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
		$json = `curl --data-binary '$json' -H 'content-type:text/plain;' $_url`;
		$json = json_decode($json, true);

		//	...
		if( $json['error'] ){
			throw new \Exception( json_encode($json['error']) );
		};

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
			if( $result = self::RPC('getaddressesbylabel',[$label]) ){
				foreach( $result as $key => $val ){

					//	...
					/*
					if(!$purpose ){
						return $key;
					};
					*/

					//	...
					if( $purpose and $purpose === $val['purpose']){
						return $key;
					};
				};

				//	...
				throw new \Exception("Does not match this purpose. ({$purpose})");
			};
		}catch( \Exception $e ){
			//	...
			$error = json_decode($e->getMessage(), true);

			//	...
			if( $error['code'] !== -11 ){
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
	static function Balance($label=null)
	{
		return self::RPC('getbalance',[$label]);
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
