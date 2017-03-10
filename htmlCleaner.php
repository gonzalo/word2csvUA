<?php

require_once 'htmlpurifier-4.8.0-lite/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.AllowedElements', 'p,b,i,strong'); //etiquetas html permitidas
$config->set('HTML.AllowedAttributes', ''); //atributos permitidos
$config->set('AutoFormat.RemoveEmpty', true); //elimina elementos vacíos

$purifier = new HTMLPurifier($config);

//get files to parse
$files = glob('rawhtml/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\nCleaning -> $file";

  //obtenemos el archivo y le limpiamos las etiquetas inútiles o vacías
  $file_content = file_get_contents($file, true);
  $clean_html = $purifier->purify($file_content);

  //quitamos también los saltos de línea el título del documento y algunosç
  //espacios vacíos
  $clean_html=str_replace("\n", " ", $clean_html);
  $clean_html=str_replace("<p> ", "<p>", $clean_html);
  $clean_html=preg_replace("/.*LISTADO.+?<\/p>/s", "", $clean_html);

  //guardamos el documento ya limpio
  $clean_file = 'cleanhtml/' . basename($file);
  file_put_contents($clean_file , $clean_html);

  echo "\nDone     -> $clean_file";

  //echo "\n$clean_html";



}

echo "\n\n";

?>
