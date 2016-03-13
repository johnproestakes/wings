<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Wings_Loader {
  private $_reserved = array();
  private $assetURI = "/application/";
  public function model($name){
    global $wings;
    $clsName = ucwords($name);
    $include = $this->_assetURI('models', strtolower($name));
    if(!isset($wings->$name)) {
      include_once $include;
      $wings->$name = new $clsName();
    }
  }
  public function helper($helpers){
    if(is_string($helpers)){

    } else if(is_array($helpers)){
      foreach($helpers as $helper){
        //$helper
      }
    }
  }
  private function _include_if_exists($fname){
    if(file_exists($fname)){
      include $fname;
    }

  }
  private function _assetURI($type, $assetName){
    return BASEURL . $this->assetURI . "$type/$assetName.php";
  }
  private function _loadView($uri, $data){
    if(is_array($data)){
      extract($data);
    }
    $fname = $uri;
    if(file_exists($fname)){
      include $fname;
    }
  }
  public function view($view, $data=array()){
    $this->_loadView($this->_assetURI('views', $view), $data);

  }


  function __construct($options=array()){
    if(array_key_exists('assetURI', $options)){
      $this->assetURI = $options['assetURI'];
    }

  }
  function __distruct(){
    $this->assetURI=null;
  }

}
