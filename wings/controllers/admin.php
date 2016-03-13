<?php

class Admin extends Wings_AdminController {
  function api(){
    global $wings;
    $wings->admin->model('installer');
    $segment = $wings->uri->segment(3);
    //echo $segment;
    $return = array();
    $wings->admin->model('admin_api');
    if(is_callable(array($wings->admin_api, $segment))){
      $return = $wings->admin_api->$segment();
    }
    Header('Content-type: application/json');
    echo json_encode($return);

  }
  function tools(){
    echo "Here are all your tools";
  }
  function login(){
    global $wings;
    $data = array(
      "scripts"=> array(
        wings_assets_dir('wings/') . "/bower_components/jquery/dist/jquery.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular/angular.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular-route/angular-route.min.js"
      ),

    );

    $wings->admin->view('login', $data);

  }
  function install(){
    global $wings;

    if(file_exists(BASEURL.'/wings/app-instance.php')){
      redirect_to('/admin');
    } else {
      $wings->admin->view('install');
    }

  }
  function logout(){
    global $wings;
    $wings->admin->model('admin_security');
    $wings->admin_security->destroyToken();
    redirect_to('/admin/login');
  }
  function settings(){
    global $wings;

    $wings->admin->model('admin_security');
    if(!$wings->admin_security->is_logged_in()){
      redirect_to('/admin/login');
    }

    $data = array(
      "app_name" => defined('APP_NAME') ? APP_NAME : "Your app",
      "pageTitle"=>"Settings",
      "plugins" => $wings->plugins->listPermitted(),
      "scripts"=> array(
        wings_assets_dir('wings/') . "/bower_components/jquery/dist/jquery.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular/angular.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular-route/angular-route.min.js"
      )
    );
    $wings->admin->view('admin/header-nomenu', $data);
    $wings->admin->view('settings', $data);
    $wings->admin->view('admin/footer', $data);

  }
  function users(){
    global $wings;
    $wings->admin->model('admin_security');
    $wings->admin->model('users');
    if(!$wings->admin_security->is_logged_in()){
      redirect_to('/admin/login');
    }

    $wings->mysqli = new Wings_MySQLi();
    $result = $wings->mysqli->query('SELECT * FROM '.TABLE_PREFIX.'users');
    while ($row = $result->fetch_row()) {
        $output = $row;
    }


    $data = array(
      "app_name" => defined('APP_NAME') ? APP_NAME : "Your app",
      "pageTitle" => "Users",
      "users_access_levels"=>$wings->users->user_access_levels(),
      "scripts"=> array(
        wings_assets_dir('wings/') . "/bower_components/jquery/dist/jquery.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular/angular.min.js",
        wings_assets_dir('wings/') . "/bower_components/angular-route/angular-route.min.js"
      ),
      "users"=>$output,
      "plugins" => $wings->plugins->listPermitted());
    $wings->admin->view('admin/header', $data);
    $wings->admin->view('users', $data);
    $wings->admin->view('admin/footer', $data);
  }
  function plugin(){
    global $wings;

    $wings->admin->model('admin_security');
    if(!$wings->admin_security->is_logged_in()){
      redirect_to('/admin/login');
    }
    $param = $wings->uri->segment(3);
    if(!isset($param) || $param == ""){
      redirect_to('/admin');
    } else {
      $plugin = $wings->plugins->loadFromSlug($wings->uri->segment(3));
      $data  = array(
        "app_name" => defined('APP_NAME') ? APP_NAME : "Your app",
        "pageTitle"=>$plugin->attr['title'],
        "plugins" => $wings->plugins->listPermitted(),
        "plugin"=>$plugin
        );

      $wings->admin->view('admin/header', $data);
      $wings->admin->view('plugin', $data);
      $wings->admin->view('admin/footer', $data);
    }

    //echo $inst->attr('pluginName');

    //load plugin page
    //echo "plugin";
  }
  function index(){
    global $wings;
    if(!file_exists(BASEURL.'/wings/app-instance.php')){
      redirect_to('/admin/install');
    } else {
      $wings->admin->model('admin_security');
      if(!$wings->admin_security->is_logged_in()){
        redirect_to('/admin/login');
      }
      //global $wings;

      //$wings->admin->view('login');
    }


    $data  = array(
      "app_name" => defined('APP_NAME') ? APP_NAME : "Your app",
      "pageTitle"=> "Welcome to Wings!",
      "plugins" => $wings->plugins->listPermitted());
    $wings->admin->view('admin/header', $data);
    $wings->admin->view('main', $data);
    $wings->admin->view('admin/footer', $data);
    // foreach( as $item){
    //   print_r($item);
    //   $item->menu_link();
    // }

  }
}
