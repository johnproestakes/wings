<?php

class Users extends Wings_Model {
  public function password_hash($password){
    $return = password_hash(
      $password,
      PASSWORD_BCRYPT,
      array("cost"=>10));
    return $return;
  }
  public function user_access_settings($current){
    global $config;
    $all = array_keys($this->user_access_levels());
    $output = array();
    foreach($all as $level){
      $output[$level] = in_array($level, $current);
    }
    return $output;
  }
  public function user_access_levels(){
    global $config;
    $default = array(
      'manage_users'=>"Manage Users",
      'manage_settings'=>"Manage Settings"
    );
    if(array_key_exists('user_access_levels',$config)){
      $keys = array_keys($config['user_access_levels']);
      foreach($keys as $key){
        if(!array_key_exists($key, $default)){
          $default[$key] = $config['user_access_levels'][$key];
        }
      }
    }
    return $default;
  }

  public function password_matches($password, $hash){
    return password_verify($password, $hash);
  }
  public function createUser($data, $mysqli=""){

      $wings = Wings_Core::getInstance();
      $wings->mysqli->insert(TABLE_PREFIX . 'users',
        array(
          "user_email"=> $data['email'],
          "user_password"=> $this->password_hash($data['password']),
          "user_access"=> $data['access']
        ));
      }
  public function install($args){


  }
}
