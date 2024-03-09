<?php
/** op-unit-bitcoin:/testcase/config.php
 *
 * @created   2021-01-09
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

/** use
 *
 */

//	2020
$config = OP()->Config('bitcoin');
D(2020, $config);

//	2024
$config = OP()->Unit('Bitcoin')->Config();
D(2024, $config);
