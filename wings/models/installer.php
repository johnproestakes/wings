<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Installer extends Wings_Model {
  public function test_connection($params){

    $required = array(
      "db_hostname",
      "db_username",
      "db_password",
      "db_name"
    );
    foreach($required as $key){
      if(!isset($params[$key])){
        return array("response"=>"bad");
      }
    }

    if(isset($params['db_port'])){
      $mysqli = new mysqli($params['db_hostname'],$params['db_username'],$params['db_password'],$params['db_name'], $params['db_port']);
    } else {
      $mysqli = new mysqli($params['db_hostname'],$params['db_username'],$params['db_password'],$params['db_name']);
    }


    if($mysqli->connect_errno){
      //try again
      $return = array('response'=>'bad');
    } else {
      //you got in.
      $return = array('response'=>'good');
    }
    return $return;
  }
  public function create_instance_file($params){

    $output = array();
    $output[] ="<?php";
    $definers = array(
      "app_name"=>"APP_NAME",
      "db_hostname"=>"DB_HOSTNAME",
      "db_username"=>"DB_USERNAME",
      "db_password"=>"DB_PASSWORD",
      "db_name"=>"DB_NAME",
      "tbl_prefix"=>"TABLE_PREFIX");
    foreach($definers as $key=>$val){
      if(isset($params[$key])){
        $output[] = "define('".$val."','".$params[$key]."');";
      }
    }


      file_put_contents(BASEURL."/wings/app-instance.php", implode($output, "\n"));
      if(file_exists(BASEURL."/wings/app-instance.php")){
        $return = array("response"=>"good");
      } else {
        $return = array("response"=>"bad");
      }


  }
  public function install($params){

    global $wings;


    $required = array(
      "db_hostname",
      "db_username",
      "db_password",
      "db_name",
      "app_name",
      "admin_email",
      "admin_password",
      "admin_confirm",
      "tbl_prefix"
    );

    foreach($required as $key){
      if(!isset($params[$key])){
        return array("response"=>"bad");
      }
    }

    $this->create_instance_file($params);

    if(!defined('TABLE_PREFIX')){
      define('TABLE_PREFIX', $params['tbl_prefix']);
    }


    if(isset($params['db_port'])){
      $mysqli = new mysqli(
        $params['db_hostname'],
        $params['db_username'],
        $params['db_password'],
        $params['db_name'],
        $params['db_port']);
    } else {
      $mysqli = new mysqli(
        $params['db_hostname'],
        $params['db_username'],
        $params['db_password'],
        $params['db_name']);
    }


    if($mysqli->connect_error){

    } else {

    }


    $createTbl = $mysqli->query('CREATE TABLE `'.TABLE_PREFIX.'users` (
    `user_id` int(11) NOT NULL,
      `user_email` varchar(128) COLLATE utf8_bin NOT NULL,
      `user_password` varchar(128) COLLATE utf8_bin NOT NULL,
      `user_access` varchar(128) COLLATE utf8_bin NOT NULL,
      `user_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;');

    if($createTbl === true){
      $mysqli->query('ALTER TABLE `'.TABLE_PREFIX.'users` ADD PRIMARY KEY (`user_id`);');
      $mysqli->query('ALTER TABLE `'.TABLE_PREFIX.'users` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;');
    }
    //add user

    $wings->admin->model('users');
    $values = array(
      "'" .$params['admin_email'] . "'",
      "'" .$wings->users->password_hash($params['admin_password']) . "'",
      "'manage_users,manage_settings'"
    );
    $mysqli->query(
    'INSERT INTO '.TABLE_PREFIX
    .'users (user_email,user_password,user_access) VALUES ('
    .implode(',',$values).')');

    $mysqli->close();
    return array("response"=>"good");


  }
}
