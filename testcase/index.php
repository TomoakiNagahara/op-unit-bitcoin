<?php
/** op-unit-bitcoin:/testcase/index.php
 *
 * @created   2020-05-05
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
use function OP\Unit;

//  ...
$config = Config::Get('bitcoin');

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

//	...
$temp = [];

//	...
$temp['balance'] = $bitcoin->Balance();

//  ...
D($config, $temp);
