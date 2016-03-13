<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Wings_Core {
  private static $_instance;
  public static function getInstance() {
      if (self::$_instance === NULL) {
          self::$_instance = new self;
      }
      return self::$_instance;
  }
  public function can_write_file($dir){
    if(is_string($dir)){
      $files = array_diff(scandir($dir), array('..', '.'));
      foreach($files as $file){
        $filepath = $dir . '/' . $file;
        if(is_dir($filepath)){
          $this->can_write_file($filepath);
        } else if( pathinfo($filepath, PATHINFO_EXTENSION) == "php") {
          //include_once $filepath;
          if(is_writable($filepath)){
            echo $filepath . " is not writable<br>";}
        } else {
          //do not import. only inports php
        }
      }
    } else if(is_array($dir)){
      foreach($dir as $folder){
        $this->can_write_file($folder);
      }
    }
  }
  public function importContentsOf($dir){

    if(is_string($dir) ){
      if(!file_exists($dir)) return false;
      $files = array_diff(scandir($dir), array('..', '.'));
      foreach($files as $file){
        $filepath = $dir . '/' . $file;
        if(is_dir($filepath)){
          $this->importContentsOf($filepath);
        } else if( pathinfo($filepath, PATHINFO_EXTENSION) == "php") {
          include_once $filepath;
        } else {
          //do not import. only inports php
        }
      }
    } else if(is_array($dir)){
      foreach($dir as $folder){
        if(!file_exists($folder)) return false;
        $this->importContentsOf($folder);
      }
    }

  }
  public function config($namespace, $path){
    if(file_exists($path)){
      include $path;
    }
  }
  function __construct(){}
  function __distruct(){}
}

ob_start();
$wings = Wings_Core::getInstance();

$wings->importContentsOf(array(
  BASEURL . "/wings/core",
  BASEURL . "/wings/models",
  BASEURL . "/wings/helpers"
));
$wings->routes = new Wings_Router();
$wings->load = new Wings_Loader();
$wings->uri = new Wings_URI();
$wings->hooks = new Wings_Hooks();

if(file_exists(BASEURL.'/wings/app-instance.php')){
  include BASEURL.'/wings/app-instance.php';

}
//load any custom configurations
if(!file_exists(APPLICATION_PATH)){
  echo "sorry man";
  mkdir(BASEURL. '/'.APPLICATION_PATH);
}
$wings->importContentsOf(APPLICATION_PATH . "/config");
$wings->routes->route();
ob_end_flush();
