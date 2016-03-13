<?php if(!defined('ENVIRONMENT')) die('No direct script access');

function wings_admin_user_can($level){
  $return = false;
  if(is_string($level)){
    if(in_array($level,$_SESSION['wings_user_access'])){
      $return = true;
    }
  }
  return $return;
}
function wings_admin_plugin($pluginObj, $group='' ){
  $wings = Wings_Core::getInstance();
  if(!isset($wings->plugins)){
    $wings->plugins = new Wings_PluginManager();
  }
  $wings->plugins->register($group, $pluginObj);
}
