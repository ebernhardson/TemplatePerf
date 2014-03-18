<?php
require_once '../lib/Twig/Autoloader.php';
Twig_Autoloader::register();

function main( $size = 1000 ) {
	$loader = new Twig_Loader_String();
	$twig = new Twig_Environment( $loader );

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
		$html = $twig->render('<div id="{{ id }}">{% for item in items %}<p>{{ item }}</p>{% endfor %}</div>', $vars );
	}
	echo "time: " . ( microtime(true) - $time_start ) . "\n";
	#echo "$html\n";
}
if(defined('HHVM_VERSION')) {
	ob_start();
	main(10000);
	ob_end_clean();
}
main();
