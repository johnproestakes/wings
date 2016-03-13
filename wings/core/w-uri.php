<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Wings_URI {
  private $_cache = array();
  private function _allSegments(){
    global $config;
    $output = array();
    if(count($this->_cache)>0){
      $output = $this->_cache;
    } else {
      if(array_key_exists('REDIRECT_URL', $_SERVER)){

        $output = array_filter(
        explode("/", substr($_SERVER['REDIRECT_URL'], strlen($config['router_basepath']), strlen($_SERVER['REDIRECT_URL']))));

      }
    }

    return $output;
  }
  private function _redirectURL(){
    if(array_key_exists('REDIRECT_URL',$_SERVER)){
      return $_SERVER['REDIRECT_URL'];
    } else {
      return "";
    }
  }

  public function path(){
    global $config;

    if(array_key_exists('REDIRECT_URL',$_SERVER)){
      $path = $this->_allSegments();
    } else {
      $path = array();
    }
    //print_r($path);
    return $path;
  }
  public function relativeBasePath() {
    $path = $this->path();
    $offset = 0;
    $output="";
    if(array_key_exists('REDIRECT_URL', $_SERVER)){
      if(substr($_SERVER['REDIRECT_URL'],strlen($_SERVER['REDIRECT_URL'])-1,1)=="/"){
        $offset+=1; //this fixes for when you have a terminal slash.
      }
    }

    if(count($path)>0){
      for($i=1; $i<(count($path)+$offset); $i++){
        $output.="../";
      }
    } else {

    }

    return $output;
  }
  public function segment($n){
    $segments = $this->_allSegments();
    $return = count($segments) >= intval($n) ? $segments[$n-1] : false;
    return $return;
  }
  function __construct(){}
  function __distruct(){}

}
