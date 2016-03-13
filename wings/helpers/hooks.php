<?php if(!defined('ENVIRONMENT')) die('No direct script access');

function wings_add_action($hook, $callable){
  $wings = Wings_Core::getInstance();
  $wings->hooks->register($hook, $callable);
}
function wings_do_action($hook){
  $wings = Wings_Core::getInstance();
  $wings->hooks->execute($hook);
}
