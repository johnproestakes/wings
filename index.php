<?
	// WELCOME TO WINGS
  session_start();
  require "wings/w-config.php";


if (defined('ENVIRONMENT')) {
	switch (ENVIRONMENT) {
		case 'development':
			error_reporting(E_ALL);
			ini_set('display_errors', 'on');
		break;

		case 'testing':
		case 'production':
			error_reporting(0);
			ini_set('display_errors', 'off');
		break;

		default:
			exit('The application environment is not set correctly.');
	}
} else {
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
}

  //route
  define('BASEURL', dirname(__FILE__));
	require "wings/w-core.php";




	//echo $_SERVER['REDIRECT_URL'];


	?>
