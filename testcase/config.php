<?php
/** op-unit-bitcoin:/testcase/config.php
 *
 * @created   2021-01-09
 * @package   op-unit-bitcoin
 * @version   1.0
 * @author    Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright Tomoaki Nagahara All right reserved.
 */

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN;

/** use
 *
 */
use OP\Config;

//  ...
$config = Config::Get('bitcoin');

//  ...
D($config);
