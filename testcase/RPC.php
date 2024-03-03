<?php
/**
 * op-unit-bitcoin:/testcase/test.php
 *
 * @created   2024-03-03
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
namespace OP\UNIT\Bitcoin;

D( $_SERVER['REQUEST_METHOD'] );

//	...
$methods = [
	'InfoBlockchain' =>  null,
	'Address'        => 'label',
];

//	...
$request = OP()->Request();
$method  = $request['method'] ?? null;
$holder  = $methods[$method]  ?? null;
$params  = $request[$holder]  ?? null;

?>
<form method="post">
	<select name="method" id="method">
		<option></option>
		<?php foreach($methods as $name => $param): ?>
			<option value="<?= $name ?>" <?= $name === $method ? 'selected':'' ?>>
				<?= $name ?>
			</option>
		<?php endforeach; ?>
	</select>
	<button> Submit </button><br/>
	<?php if( $holder ): ?>
	<input type="text" name="<?= $holder ?>" value="<?= $params ?>" placeholder="<?= $holder ?>" /><br/>
	<?php endif; ?>
</form>
<script>
document.getElementById('method').addEventListener('change', function(e){
	location.href = location.origin + location.pathname + '?method=' + e.target.value;
});
</script>
<hr/>
<?php
//	...
if( $method and $_SERVER['REQUEST_METHOD'] === 'POST' ){
	/* @var $bitcoin \OP\UNIT\Bitcoin */
	$bitcoin = OP()->Unit('Bitcoin');
	D( $method, $params );
	D( $bitcoin->RPC()->$method($params) );
}

//	For Eclipse notice
if( 0 ){
	D($param);
}
