<?php
require_once '../lib/lightncandy/src/lightncandy.php';

function main( $size = 100000 ) {
	$time_start = microtime(true);
	// Rendered PHP of template
	$phpStr = LightnCandy::compile( '<div id="{{ id }}">{{ body }}</div>', array(
		'flags' => 0,
	) );

	// Store the template...
	// Method 1 (preferred):
	//$php_inc = './cache/' . substr( basename( __FILE__ ), 0, -4 ) . '.cache.php';
	//file_put_contents($php_inc, $phpStr);
	//$renderer = include($php_inc);
	// Method 2 (potentially insecure):
	$renderer = LightnCandy::prepare( $phpStr );

	for ( $n=$size; $n >= 0; --$n ) {
		$vars['id'] = "divid$n";
		$vars['body'] = 'my div\'s body';
		$html = $renderer( $vars );
	}
	echo "time: " . ( microtime(true) - $time_start ) . "\n";
	echo "$html\n";
}

// pre-warm jit
if(defined('HHVM_VERSION')) {
	ob_start();
	main(1000);
	main(1000);
	ob_end_clean();
}

main();
