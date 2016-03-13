<?php if(!defined('ENVIRONMENT')) die('No direct script access');

//check custom routes
class Wings_Router {

  public $customRoutes = array();
  public $notFound;
  public $controllerRoutes = array();
  public $root;

  function controller($route, $path){
    $this->controllerRoutes[] = array($route, $this->_pathToArray($path));
    }
  function controllers($all){
    foreach($all as $route){
      $this->controller($route[0], $route[1]);
      }
    }

  function custom($route, $path /* as array */ ){
    $this->customRoutes[] = array($route, $this->_pathToArray($path));
    }
  function customs($all){
    foreach($all as $route){
      $this->custom($route[0], $route[1]);
      }
    }

  function not_found($path /* as array */){
    $this->notFound = $this->_pathToArray($path);
    }

  private function _pathToArray($path){
    if(is_string($path)){
      return explode("/", $path);
    } else if (is_array($path)){
      return $path;
    }
  }
  function root($path /* as array */){
    //path as string
    $this->root = $this->_pathToArray($path);

    }
  function route(){
    global $wings;
    $path = $wings->uri->path();
    $routed = false;
    foreach(array(
      "applyRootRouting",
      "applyAdminRouting",
      "applyCustomRouting",
      "applyControllerRouting",
      "applyNotFoundRouting") as $method){
      if($this->$method($path)){
        $routed = true;
        break;
      }
    }
    if(!$routed) die('You don\'t have any routes or controllers set up');
    }



  private function applyRootRouting($path){
    $status = false;
    if(count($path)==0){
      $status = true;
      $this->routeToController($this->root);
      }
    return $status;
  }
  private function applyAdminRouting($path){
    $status = false;
    $testPath = implode($path, "#");
    $wings = Wings_Core::getInstance();

    if($wings->uri->segment(1)=="admin"){
      $wings->admin = new Wings_Loader(array('assetURI'=>"/wings/"));
      $wings->plugins = new Wings_PluginManager();
      $wings->importContentsOf(APPLICATION_PATH . "/plugins");
      $this->routeToController($wings->uri->path(), BASEURL . "/wings/controllers/");
      $status = true;
      //die('Time to install wings');
    }
    return $status;
  }
  private function applyCustomRouting($path){
    $status = false;
    $testPath = implode($path, "/");

    foreach($this->customRoutes as $testRoute){
      if($testRoute[0] == $testPath){
        $status = true;
        $this->routeToController($testRoute[1]);
        break;
        }
      }
      $testPath = null;

    return $status;
  }
  private function applyControllerRouting($path){
    $status = false;
    //explicit references
    foreach($this->controllerRoutes as $testRoute){
      if($testRoute[0] == $path[0]){
        $status = true;
        $this->routeToController($testRoute[1]);
        break;
      }
    }
    //check controller directory.
    if(!$status){
      if(file_exists(APPLICATION_PATH . "/controllers/" . $path[0] . ".php")){
          $status = true;
          $this->routeToController($path);
        }
      }

    return $status;
  }
  private function applyNotFoundRouting($path){
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    if(!isset($this->notFound)){
      die('page could not be found');
    } else {
      $this->routeToController($this->notFound);
    }

    return true;
  }

  private function routeToController($path, $origin=""){
    if(count($path)==1)
      $path[] = "index";

    if(count($path)>=2){
      if($origin ==""){
        include APPLICATION_PATH . "/controllers/" . $path[0] . ".php";
      } else {
        include $origin . $path[0] . ".php";
      }


      if(count(explode('/', $path[0]))>1){
        $p1 = explode("/", $path[0] );
        $path[0] = array_pop($p1);
      }
      $cls = ucwords($path[0]);
      $instance = new $cls;
      $path[1] = str_replace("-", "_", $path[1]);
      if(method_exists($cls, $path[1])){
        $instance->$path[1]();
      } else {
        if(strtolower($path[0]) == strtolower($this->notFound[0])){
          //$class is already delcared;
          $meth = $this->notFound[1];
          if(method_exists($cls, $meth)){
            $instance->$meth();
          }

        } else {
          $this->routeToController($this->notFound);
        }

      }
    }
  }

  function __construct(){ }
  function __distruct(){
    //kill variables
    $this->customRoutes = null;
    $this->controllerRoutes = null;
    $this->notFound = null;
    $this->root = null;
  }
}
