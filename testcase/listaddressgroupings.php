<?php

/** namespace
 *
 */
namespace OP\UNIT\BITCOIN;

/** use
 *
 */
use function OP\Unit;

/* @var $bitcoin \OP\UNIT\Bitcoin */
$bitcoin = Unit('Bitcoin');

//	...
D($bitcoin->RPC('listaddressgroupings'));
