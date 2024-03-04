<?php
/** op-unit-bitcoin:/testcase/index.php
 *
 * @created    2021-01-02
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
