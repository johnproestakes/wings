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

  if(!file_exists('.htaccess')){
    $offset = dirname($_SERVER['SCRIPT_NAME']) . "/";
    //echo $offset;


    $content =  array(
        "# BEGIN Wings",
        "<IfModule mod_rewrite.c>",
        "RewriteEngine On",
        sprintf("RewriteBase %s", $offset),
        "RewriteRule ^index\.php$ - [L]",
        "RewriteCond %{REQUEST_FILENAME} !-f",
        "RewriteCond %{REQUEST_FILENAME} !-d",
        sprintf("RewriteRule . %sindex.php [L]", $offset),
        "</IfModule>",
        "# If you need to move this instance of wings, you can always delete this file, it is regenerated when it goes missing",
        "# END Wings"
      );
    $fhandle = fopen('.htaccess', 'w');

    fwrite($fhandle, implode("\n", $content));
    fclose($fhandle);

    die('<noscript>Reload this page!</noscript><script>location.reload();</script>');
    //header('Location: '. $_SERVER['REDIRECT_URL']);
    //


  }

// print_r($_SERVER);
//   die('');
  $protocol = explode("/", $_SERVER['SERVER_PROTOCOL']);
  $protocol = strtolower(array_shift($protocol));
  $config['site_url'] = $protocol."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']) . "/";
  $config['router_basepath']= dirname($_SERVER['SCRIPT_NAME']) . "/";

  // print_r($config);
  // die('');
  define('BASEURL', dirname(__FILE__));
	require "wings/w-core.php";




	//echo $_SERVER['REDIRECT_URL'];


	?>
