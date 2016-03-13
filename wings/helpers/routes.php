<?php if(!defined('ENVIRONMENT')) die('No direct script access');

function redirect_to($addr){
  Header('Location: ' . link_to($addr));
}
