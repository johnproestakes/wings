<?php if(!defined('ENVIRONMENT')) die('No direct script access');


class Wings_Notification {

}
class Wings_PluginManager {
  private $_plugins = array();
  function register($type, $instance){
    if($instance instanceof Wings_Plugin){
      if(array_key_exists($type, $this->_plugins)){
        $this->_plugins[$type][]=$instance;
      } else {
        $this->_plugins[$type]=array($instance);
      }
    } else {

    }

  }
  function loadFromSlug($slug){
    $keys = array_keys($this->_plugins);
    foreach($keys as $key){
      foreach($this->_plugins[$key] as $plugin){
        if($plugin->attr['slug']==$slug)
          return $plugin;
      }
    }

  }

  function listPermitted(){
    $output = array();
    $types = array_keys($this->_plugins);


    foreach($this->_plugins as $type=>$blob){
      foreach($blob as $plugin){
        if(is_string($plugin->attr['capability'])){
          $plugin_access = explode(',',$plugin->attr['capability']);
        } else {
          $plugin_access = $plugin->attr['capability'];
        }
        
        $access = array_intersect($plugin_access,$_SESSION['wings_user_access']);

        if(count($access)>0){
          if(!array_key_exists($type, $output)){
            $output[$type] = array();
          }
          $output[$type][]=$plugin;
        }
      }


}
return $output;




  }
  function listAll(){
    //should compare against user's action
    return $this->_plugins;
  }
}



class Wings_Dashboard {
  public $attr = array(
    "title"=>"",
    "label"=>"",
    "capability"=>"",
    "slug"=>"",
    "function"=>"",
    "icon"=>""
  );
  function __construct(){

  }
}

class Wings_Plugin {
  public $attr = array(
    "title"=>"",
    "label"=>"",
    "capability"=>"",
    "slug"=>"",
    "function"=>"",
    "icon"=>""
  );

  function __construct($title, $label, $capability, $slug, $function="", $icon="" ){
    $args = func_get_args();
    $i = 0;
    foreach($this->attr as $key=>$value){
      if(array_key_exists($i, $args))
        $this->attr[$key] = $args[$i];
      $i++;

    }
    // if(is_callable($this->attr['function'])){
    //   call_user_func($this->attr['function']);
    // }

  }
  function __distruct(){

  }

}


//$plugin_menu = new Wings_AdminMenu('left', 'plugins', 'Plugins');
