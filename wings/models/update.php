<?php

class Update extends Wings_Model {
  private function extract_archive($archive){
    $zip = new ZipArchive;
    if(!file_exists(BASEURL."/wings-update")){
      mkdir(BASEURL."/wings-update");
    }
      if ($zip->open($archive) === TRUE) {
          $zip->extractTo(BASEURL."/wings-update");
          $zip->close();
          echo 'ok';
      } else {
          echo 'failed';
      }

      $this->traverse_replace(BASEURL, BASEURL."/wings-update/wings-master");
      //$this->traverse_replace(BASEURL, BASEURL."/wings-update/wings-master");
     unlink($newfile);
     $this->unlink_tree(BASEURL."/wings-update");
    //rmdir(BASEURL."/wings-update");

  }
  private function unlink_tree($dir){

   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? $this->unlink_tree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);


  }
  private function replace_file($file, $with){
    if(file_exists($file)){
      $fhandle = fopen($file,"r");
      $content = fread($fhandle,filesize($file));

      $fhandle = fopen($with,"w");
      fwrite($fhandle,$content);
      fclose($fhandle);
      //echo "<li>" . $file . " -> " . $with . "</li>";
    }
  }
  private $ignores = array(
    ".", "..",".DS_Store",".gitignore",".git",".htaccess","README.md","app-instance.php"
  );
  private function traverse_replace($start, $end){
    $files = array_diff(scandir($end), $this->ignores);

    // echo "<ul>";
    foreach($files as $file){
      $fname = $start . '/' .$file;
      if(is_dir($fname)){
        $this->traverse_replace($fname, $end . '/' . $file);
      } else {
        $this->replace_file($fname, $end . '/'. $file);
      }
    }
    // echo "</ul>";

  }




  public function update_wings(){
    $file = 'https://github.com/johnproestakes/wings/archive/master.zip';
    $newfile = BASEURL.'/tmp_file.zip';

    if (!copy($file, $newfile)) {
      echo "failed to copy $file...\n";
    } else {
      $this->extract_archive($newfile);
    }



  }
}
