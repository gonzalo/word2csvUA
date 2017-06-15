<?php

//elimina todo el código html innecesario y separa el contenido en dos archivos
//uno para las descripciones de población y otro para los represaliados

require_once 'htmlpurifier-4.8.0-lite/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.AllowedElements', 'p,b,i,strong,sub,sup'); //etiquetas html permitidas
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

  //Separamos los dos bloques: el de población + descripción y el del listado
  $reg_exp_poblacion = "/(.*)LISTA.*/s";
  $reg_exp_represaliados = "/.*LISTA.+?(.*)<\/p>/s";

  //purificamos de nuevo antes de guaradar para tener un buen html
  preg_match($reg_exp_poblacion, $clean_html, $matches);
  $clean_html_poblacion= $matches[1];
  $clean_html_poblacion = $purifier->purify($clean_html_poblacion);

  preg_match($reg_exp_represaliados, $clean_html, $matches);
  $clean_html_represaliados= $matches[1];
  $clean_html_represaliados = $purifier->purify($clean_html_represaliados);

  //guardamos el documento ya limpio
  $clean_file_poblacion = 'cleanhtml/poblaciones/' . basename($file);
  $clean_file_represaliados = 'cleanhtml/represaliados/' . basename($file);
  file_put_contents($clean_file_poblacion , $clean_html_poblacion);
  file_put_contents($clean_file_represaliados , $clean_html_represaliados);

  echo "\nDone     -> $clean_file_poblacion";
  echo "\nDone     -> $clean_file_represaliados";

  //echo "\n$clean_html";



}

echo "\n\n";

?>
