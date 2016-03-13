<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Admin_Api extends Wings_Model {
  public function user_list(){
    //has admin rights;
    $return = array("response"=>array());

    $wings = Wings_Core::getInstance();
    $wings->admin->model('admin_security');


    if(!$wings->admin_security->is_logged_in() || !wings_admin_user_can('manage_users')) {
      $return['errors'] = array("You do not have sufficient rights to request this data");
      }

    if(!array_key_exists('errors', $return)){
      $wings->mysqli = new Wings_MySQLi();
      $result = $wings->mysqli->query(
        'SELECT user_email, user_access FROM '.TABLE_PREFIX.'users');

      if($result){
        $output = array();
        $wings->admin->model('users');
        while($row=$result->fetch_assoc()){
          $access = explode(',', $row['user_access']);
          $row['user_access1']=$access;
          $row['user_access']=$wings->users->user_access_settings($access);
          $output[] = $row;
        }
        $return = array("response"=>$output);
      }
    }

    return $return;
  }
  public function install_wings(){
    $wings = Wings_Core::getInstance();
    $wings->admin->model('installer');
    $params = $this->_post_params();
    $return = $wings->installer->install($params);
    return $return;
  }
  public function db_connection(){
    $wings = Wings_Core::getInstance();
    $wings->admin->model('installer');
    $params = $this->_post_params();
    $return = $wings->installer->test_connection($params);

  }
  public function user_login(){
    $params = $this->_post_params();
    $return = array(
      "access_granted"=>false,
      "message"=>"Could not verify these login credentials. Try again.");

    $wings = Wings_Core::getInstance();
    // $params['user_email'] = "jproestakes@gmail.com";
    // $params['user_password'] = "Saagapo25";

    $wings->mysqli = new Wings_MySQLi();
    $wings->admin->model('users');
    $result = $wings->mysqli->fetch(
      TABLE_PREFIX."users",
      "user_email='".$params['user_email']."'");

    while($row = $result->fetch_assoc()){
      if($wings->users->password_matches($params['user_password'], $row['user_password'])){
        $return = array("access_granted"=>true);
        //pull in the security algorithm;
        $wings->admin->model('admin_security');
        $wings->admin_security->setToken($row['user_id'], $row['user_access']);
      }
    }
    return $return;
  }
  private function _post_params($array=true){
    return json_decode(file_get_contents("php://input"), $array);
  }
  private function _get_params($array=true){

    return $_GET;
  }

  function __construct(){
    parent::__construct();
  }
}
