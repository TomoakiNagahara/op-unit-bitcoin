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
}
