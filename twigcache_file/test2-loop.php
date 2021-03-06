<?php
require_once '../lib/Twig/Autoloader.php';
Twig_Autoloader::register();

function main( $size = 1000 ) {
$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment( $loader, array(
		'cache' => 'cache',
	) );

	$items = array();
	for ( $n=0; $n <= $size; ++$n ) {
		$items['a'.mt_rand()] = time();
	}

	$time_start = microtime(true);
	for ( $n=0; $n <= $size; ++$n ) {
		$key = array_rand( $items );
		$items[$key] = 'b'.mt_rand();
		$vars['items'] = $items;
		$vars['id'] = "divid";
		$vars['body'] = 'my div\'s body';
		$html = $twig->render( 'test2_multidiv.html', $vars );
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
