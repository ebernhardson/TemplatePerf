<?php
require_once '../lib/lightncandy/src/lightncandy.php';

function main( $size = 1000 ) {
	$items = array();
	for ( $n=0; $n <= $size; ++$n ) {
		$items['a'.mt_rand()] = time();
	}

	$time_start = microtime(true);
	// Rendered PHP of template
	$phpStr = LightnCandy::compile( '<div id="{{ id }}">{{# m_items }}<div id="{{ key }}">{{ val }}</div>{{/ m_items }}</div>', array(
		'flags' => 0,
	) );
	// Store the template...
	// Method 1 (preferred):
	//$php_inc = './cache/' . substr( basename( __FILE__ ), 0, -4 ) . '.cache.php';
	//file_put_contents($php_inc, $phpStr);
	//$renderer = include($php_inc);
	// Method 2 (potentially insecure):
	$renderer = LightnCandy::prepare( $phpStr );
	for ( $n=0; $n <= $size; ++$n ) {
		$vars['id'] = "divid";
		$vars['body'] = 'my div\'s body';
		$m_items = array();
		foreach ( $items as $key => $val ) {
			$m_items[] = array( 'key'=>$key, 'val'=>$val );
		}
		$vars['m_items'] = $m_items;
		$html = @$renderer( $vars );
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
