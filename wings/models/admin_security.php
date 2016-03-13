<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Admin_Security extends Wings_Model {
  function users_ID(){
    if($this->is_logged_in()){
      return $_SESSION['wings_admin_token'];
    } else {
      return false;
    }
  }
  function destroyToken(){
    session_regenerate_id();
    unset($_SESSION['wings_admin_token']);
  }
  function setToken($userId, $access){
    session_regenerate_id();
    $_SESSION['wings_admin_token'] = $userId;
    $_SESSION['wings_user_access'] = $access=="" ? array() : explode(',', $access);
  }
  public function is_logged_in(){
    if(array_key_exists('wings_admin_token', $_SESSION)){
      return true;
    } else {
      return false;
    }
  }

  function __construct(){
    parent::__construct();
  }
}
