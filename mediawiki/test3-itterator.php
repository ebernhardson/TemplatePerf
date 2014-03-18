<?php
$wgWellFormedXml = true;

require_once 'Html.php';
require_once 'Xml.php';

function main( $size = 1000 ) {
	$items = array();
	for ( $n=0; $n <= $size; ++$n ) {
		$items[] = "value:" . mt_rand();
	}

	$time_start = microtime(true);
	for ( $n=0; $n <= $size; ++$n ) {
		$key = array_rand( $items );
		$items[$key] = 'b:'.mt_rand();
		$vars['items'] = $items;
		$vars['id'] = "divid";
		$vars['body'] = 'my div\'s body';
		$body = '';
		foreach ( $vars['items'] as $item ) {
			$body .= Html::element(
				'p',
				array(),
				$item
			);
		}
		$html = Html::rawElement(
			'div',
			array( 'id' => $vars['id'] ),
			$body
		);
	}
	echo "time: " . ( microtime(true) - $time_start ) . "\n";
	#echo "$html\n";
}
if(defined('HHVM_VERSION')) {
	ob_start();
	main(100);
	ob_end_clean();
}

main();
