<?php
function main( $size = 100000 ) {
	require_once '../lib/Twig/Autoloader.php';
	Twig_Autoloader::register();


	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment( $loader, array(
		'cache' => 'cache',
	) );

	$time_start = microtime(true);
	for ( $n=0; $n <= $size; ++$n ) {
		$vars['id'] = "divid$n";
		$vars['body'] = 'my div\'s body';
		$html = $twig->render( 'test1_singlediv.html', $vars );
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
