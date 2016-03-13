<?php if(!defined('ENVIRONMENT')) die('No direct script access');

function wings_load_view($view, $data=array()){
  $wings = Wings_Core::getInstance();
  $wings->load->view($view, $data);
}
function tpl_var($var, $source=array(), $default="") {
  if(!is_string($var) && isset($var)){
    return $var;
  } else if(array_key_exists($var, $source)){
    return $source[$var];
  } else {
    return $default;
  }
}
function wings_rel_base_dir(){
  $wings = Wings_Core::getInstance();
  $path = $wings->uri->relativeBasePath();
}
function wings_assets_dir($offset=""){
  $wings = Wings_Core::getInstance();
  $path = $wings->uri->relativeBasePath() . $offset . "assets";
  return $path;
}
function siteurl(){
  global $config;
  return substr($config['site_url'],0, strlen($config['site_url'])-1);
}
function link_to($link, $echo=false){
  $output = siteurl() . $link;
  if($echo){
    echo $output;
  } else {
    return $output;
  }
}
