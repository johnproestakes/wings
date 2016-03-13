<?php if(!defined('ENVIRONMENT')) die('No direct script access');

class Wings_MySQLi {
  private $mysqli;
  public function insert($tbl, $data){
    $fields  = array_keys($data);
    $values = array();
    foreach($fields as $key){
      if(is_numeric($data[$key])){
        $values[] = $data[$key];
      } else {
        $values[] = "'" . $data[$key] . "'";
      }
    }
    $result = $this->mysqli->query("INSERT INTO $tbl (".implode(",", $fields) . ") VALUES (".implode(",",$values).")");
    if($result){

    } else {

    }
      return $result;
  }
  public function fetch($tbl, $where="", $limit=""){
    $query = implode(" ", array("SELECT * FROM",$tbl,isset($where) ? "WHERE " . $where : ""));
    return $this->mysqli->query($query);
  }

  public function query($query){
    $args = func_get_args();
  // @query  $args[0]
  // @args = [1-x]

    return $this->mysqli->query($query);
  }
  function __construct($mysqli_obj=""){
    if(defined('DB_HOSTNAME')){

      if(defined('DB_PORT')){
        $this->mysqli = new mysqli(
          DB_HOSTNAME,
          DB_USERNAME,
          DB_PASSWORD,
          DB_NAME,
          DB_PORT
        );
      } else {
        $this->mysqli = new mysqli(
          DB_HOSTNAME,
          DB_USERNAME,
          DB_PASSWORD,
          DB_NAME);
      }
    } else {
      if($mysqli instanceof mysqli){
        $this->mysqli = $mysqli_obj;
      } else {

      }
    }
  }
  function __distruct(){
    $this->mysqli->close();
  }

}
