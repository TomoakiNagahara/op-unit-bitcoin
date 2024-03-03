<?php
/** op-unit-bitcoin:/include/config.php
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

//	...
$config = OP()->Config('bitcoin');

//	...
if( $path = $config['bitcoin.conf'] ?? null ){
	//	...
	if( file_exists($path) ){
		//	...
		if( $file = file_get_contents($path) ){
			//	...
			$section = 'general';

			//	...
			$config['bitcoin.conf'] = [];

			//	...
			foreach( explode("\n", $file) as $line ){
				//	...
				$line = trim($line);

				//	...
				if( empty($line) ){
					continue;
				}

				//	...
				if( $line[0] === '#' ){
					continue;
				}

				//	Get Section label
				/* @var $match array */
				if( preg_match('|^\[(.+)\]$|', $line, $match) ){
					//	Overwrite section label
					$section = $match[1];
					continue;
				}

				//	...
				list($key, $value) = explode('=', $line);

				//	...
				$config['bitcoin.conf'][$section][$key] = $value;
			}
		}
	}
}

//	...
return $config;
