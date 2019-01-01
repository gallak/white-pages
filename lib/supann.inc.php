<?php

function load_supann_nomenclature($dir,$type){
  $types=[];
  $refs=[];
  $files = scandir($dir);
  foreach($files as $f){
    $rules="/".$type."_/";
    if (preg_match($rules,$f)){
      $refs[]=str_replace($type."_", "", $f);
    }
  }

  foreach($refs as $ref){
    if (($handle = fopen($dir.'/'.$type.'_'.$ref, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	$types[$ref][$data[0]] = $data[1];
      }
    fclose($handle);
    }
  }
return($types);
}

function get_entite_label($field,$nomenclature){
  $fieldArray=preg_split("/{|}/",$field);
  return($nomenclature[$fieldArray[1]][$fieldArray[2]]);
}

?>
