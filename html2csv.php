<?php

$files = glob('cleanhtml/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\nParsing to csv -> $file";

  //obtenemos el archivo
  $file_content = file_get_contents($file, true);

  //divide string mediante expresión regular
  //https://regex101.com/
  //falla con los saltos de línea "los elimino en la línea anterior"
  $regexp_paragraphs = "/<p>(.+?)<\/p>/"; //para separar los párrafos
  $regexp_titles = "/([^.]+?)\. (.*)/";  //para separar nombre y causa
  $expedientes = [];

  //separamos los párrafos en un array
  preg_match_all($regexp_paragraphs, $file_content, $raw_paragraphs);

  //por cada parrafo
  foreach ($raw_paragraphs[1] as $paragraph) {

    //extraemos el nombre y la causa
    preg_match_all($regexp_titles, $paragraph, $raw_expediente);
    $expediente = [
      $raw_expediente[1][0], //nombre
      $raw_expediente[2][0], //causa
    ];
    array_push($expedientes, $expediente);

  }


  //writing array to csv file
  $csv_file_name = 'rawcsv/' . basename($file,'.html') . '.csv';
  $csv_file = fopen( $csv_file_name, 'w');

  foreach ($expedientes as $expediente) {
    fputcsv( $csv_file, $expediente, ',', '"');
  }

  fclose( $csv_file );

  echo "\nDone           -> $csv_file_name";

}


 ?>
