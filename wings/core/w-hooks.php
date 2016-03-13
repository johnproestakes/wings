<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Wings_Hooks {
  private $_hooks = array();
  private static $_instance;
  public static function getInstance() {
      if (self::$_instance === NULL) {
          self::$_instance = new self;
      }
      return self::$_instance;
  }

  public function execute($hook) {
    if(array_key_exists($hook, $this->_hooks)){
      foreach($this->_hooks[$hook] as $handler){
        if(is_callable($handler)){
          call_user_func($handler);
        }
      }
    }
  }

  public function register($hook, $callable){
    if(array_key_exists($hook, $this->_hooks)){
      $this->_hooks[$hook][] = $callable;
    } else {
      $this->_hooks[$hook] = array();
      $this->_hooks[$hook][] = $callable;
    }
  }

}

//$plugin_menu = new Wings_AdminMenu('left', 'plugins', 'Plugins');
