<?php

//elimina todo el código html innecesario y separa el contenido en dos archivos
//uno para las descripciones de población y otro para los represaliados

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

  //quitamos también los saltos de línea y algunos espacios vacíos
  $clean_html=str_replace("\n", " ", $clean_html);
  $clean_html=str_replace("<p> ", "<p>", $clean_html);


  //para los represariados quitamos el todo hasta "REPRESALIADOS"
  $clean_html_represaliados=preg_replace("/.*LISTA.+?<\/p>/s", "", $clean_html);

  //guardamos el documento ya limpio
  $clean_file_represaliados = 'cleanhtml/represaliados/' . basename($file);
  file_put_contents($clean_file_represaliados , $clean_html_represaliados);

  echo "\nDone     -> $clean_file_represaliados";

  //echo "\n$clean_html";



}

echo "\n\n";

?>
