<?php

//fase 1
//extraer nombre de población y descripción

// convertimos de html a csv los archivos de represaliados
$files = glob('cleanhtml/poblaciones/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\nParsing file población-> $file";

  //obtenemos el archivo
  $file_content = file_get_contents($file, true);



  //divide string mediante expresión regular
  //captura un grupo con el nombre de la población y otro con su descripción
  $regexp = "/( <p><b>.*<\/b><\/p>| .*?)( <p>.*)/";
  preg_match($regexp, $file_content, $matches);

  //antes de guardar limpiamos código html, espacios sobrantes...
  $nombre_poblacion = trim(strip_tags($matches[1]));
  $descripcion_poblacion = trim($matches[2]);

  $datos_poblacion = [$nombre_poblacion, $descripcion_poblacion];

  //writing array to csv file
  $csv_file_name = 'rawcsv/poblaciones/' . basename($file,'.html') . '.csv';
  $csv_file = fopen( $csv_file_name, 'w');

  fputcsv( $csv_file, $datos_poblacion, ',', '"');

  fclose( $csv_file );

  echo "\nDone  población -> $csv_file_name";

}




//fase 2
//extraer los expedientes de represaliados

// convertimos de html a csv los archivos de represaliados
$files = glob('cleanhtml/represaliados/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\nParsing file represaliados-> $file";

  //obtenemos el archivo
  $file_content = file_get_contents($file, true);

  //divide string mediante expresión regular
  //https://regex101.com/
  //falla con los saltos de línea "los elimino en la línea anterior"
  $regexp_paragraphs = "/<p>(.+?)<\/p>/"; //para separar los párrafos
  $regexp_titles = "/([^.]+?)\. (.*)/";  //para separar nombre y causa

  //cadena alternativa, si se ajusta el fichero de origen podríamos extraer
  //un campo más procendencia.
  //$regexp_titles = "/([^.]+?)\. ([^.]+?)\. (.*)/";  //para separar nombre, procedencia y causa
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
      //$raw_expediente[2][0], //procedencia
      //$raw_expediente[3][0], //causa
    ];
    array_push($expedientes, $expediente);
  }


  //writing array to csv file
  $csv_file_name = 'rawcsv/represaliados/' . basename($file,'.html') . '.csv';
  $csv_file = fopen( $csv_file_name, 'w');

  foreach ($expedientes as $expediente) {
    fputcsv( $csv_file, $expediente, ',', '"');
  }

  fclose( $csv_file );

  echo "\nDone  represaliados -> $csv_file_name";

}


 ?>
