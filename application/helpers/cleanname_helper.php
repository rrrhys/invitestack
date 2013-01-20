    <?php
    function clean_name($name){
      if(substr($name,0,12) == "input_merge_"){
        $name = substr($name,12);
      }
      $name = str_replace("_", " ", $name);
      return ucwords($name);
    }?>
      