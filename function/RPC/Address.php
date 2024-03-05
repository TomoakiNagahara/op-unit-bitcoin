<?php
/** op-unit-bitcoin:/function/RPC/Address.php
 *
 * @created    2024-03-05
 * @version    1.0
 * @package    op-unit-bitcoin
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN\RPC;

/** Get new address / already address.
 *
 * @moved  2024-03-05
 * @param  string     $label
 * @param  string     $purpose
 * @return array
 */
function Address(string $label=null, string $purpose='receive')
{
	//	...
	try{
		//	Convert to md5.
		$label = md5($label);

		/*
		$label = Encode($label);
		$label = nl2br($label);
		*/

		//	Get already generated address.
		if( $result = self::RPC('getaddressesbylabel',[$label]) ){

			//	Get first address.
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
		if(($error['code'] ?? null) !== -11 ){
			throw $e;
		};
	};

	//	...
	return self::RPC('getnewaddress',[$label]);
}
