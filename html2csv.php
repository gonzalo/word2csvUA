<?php

$files = glob('cleanhtml/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\n\nParsing to csv -> $file";

  $file_content = file_get_contents($file, true);
  $file_content_no_nl = trim($file_content, '\n');

  //divide string mediante expresión regular
  //\<p\>([^.]*)\.(.*)\<\/p>  https://regex101.com/
  //preg_split


  $parsed_file = [
    [ 'MOLINA GARCIA, Antonio' , 'Esta es su historia' ],
    [ 'MARTÍNEZ GARCIA, Alonso' , 'Esta es su historia 2'],
  ];

  //writing array to csv file
  $csv_file_name = 'rawcsv/' . basename($file,'.html') . '.csv';
  $csv_file = fopen( $csv_file_name, 'w');

  foreach ($parsed_file as $expediente) {
    fputcsv( $csv_file, $expediente, '|', '"');
  }

  fclose( $csv_file );

  echo "\nDone           -> $csv_file_name";
}


 ?>
