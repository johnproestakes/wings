<?php

class Update extends Wings_Model {
  public function password_hash($password){
    $file = 'http://remote/url/file.zip';
    $newfile = 'tmp_file.zip';

    if (!copy($file, $newfile)) {
        echo "failed to copy $file...\n";
    }
    
    $zip = new ZipArchive;
      if ($zip->open('test.zip') === TRUE) {
          $zip->extractTo('/my/destination/dir/');
          $zip->close();
          echo 'ok';
      } else {
          echo 'failed';
      }
  }
}
