<?php
function main( $size = 100000 ) {
	$wgWellFormedXml = true;

	require_once 'Html.php';
	require_once 'Xml.php';

	$time_start = microtime(true);
	for ( $n=0; $n <= $size; ++$n ) {
		$vars['id'] = "divid$n";
		$vars['body'] = 'my div\'s body';
		$html = Html::element( 'div', array( 'id' => $vars['id'] ), $vars['body'] );
	}
	echo "time: " . ( microtime(true) - $time_start ) . "\n";
	echo "$html\n";
}
if(defined('HHVM_VERSION')) {
	ob_start();
	main(10000);
	ob_end_clean();
}

main();
