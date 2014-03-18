<?php
require_once '../lib/lightncandy/src/lightncandy.php';

// Rendered PHP of template
function main( $size = 1000 ) {
	$items = array();
	for ( $n=0; $n <= $size; ++$n ) {
		$items[] = "value:" . mt_rand();
	}

	$time_start = microtime(true);
	$phpStr = LightnCandy::compile(
		'<div id="{{ id }}">{{# items }}<p>{{ . }}</p>{{/ items }}</div>',
		array(
			'flags' => LightnCandy::FLAG_THIS
		)
	);
	// Store the template...
	// Method 1 (preferred):
	//$php_inc = './cache/' . substr( basename( __FILE__ ), 0, -4 ) . '.cache.php';
	//file_put_contents($php_inc, $phpStr);
	//$renderer = include($php_inc);
	// Method 2 (potentially insecure):
	$renderer = LightnCandy::prepare( $phpStr );
	for ( $n=0; $n <= $size; ++$n ) {
		$key = array_rand( $items );
		$items[$key] = 'b:'.mt_rand();
		$vars['items'] = $items;
		$vars['id'] = "divid";
		$vars['body'] = 'my div\'s body';
		$html = $renderer( $vars );
	}
	echo "time: " . ( microtime(true) - $time_start ) . "\n";
	echo "$html\n";
}

if(defined('HHVM_VERSION')) {
	ob_start();
	main(100);
	main(100);
	ob_end_clean();
}

main();
