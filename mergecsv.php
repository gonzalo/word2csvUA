<?php

//fusionamos los archivos de poblaciones

$merged_csv_filename = 'mergedcsv/poblaciones-final.csv';
$csv_merged_file = fopen( $merged_csv_filename, 'w');

$files = glob('rawcsv/poblaciones/*.{csv}', GLOB_BRACE);

foreach ($files as $file) {

  echo "\nMerging -> $file";

  $poblacion = basename($file, '.csv');

  //obtenemos el archivo y lo limpiamos de saltos de línea y espacios inútiles
  $csv_file = fopen( $file, 'r');
  while (!feof($csv_file)) {

    $csv_row = fgetcsv($csv_file);

    if (is_array($csv_row))
    {
      //lo guardamos en el archivo final
      fputcsv( $csv_merged_file, $csv_row, ',', '"');
    }
  }
  fclose( $csv_file );

}

fclose($csv_merged_file);

echo "\n\nMerge done -> $merged_csv_filename \n";

//fusionamos los archivos de represaliados

$merged_csv_filename = 'mergedcsv/represaliados-final.csv';
$csv_merged_file = fopen( $merged_csv_filename, 'w');

$files = glob('rawcsv/represaliados/*.{csv}', GLOB_BRACE);

foreach ($files as $file) {

  echo "\nMerging -> $file";

  $poblacion = basename($file, '.csv');

  //obtenemos el archivo y lo limpiamos de saltos de línea y espacios inútiles
  $csv_file = fopen( $file, 'r');
  while (!feof($csv_file)) {

    $csv_row = fgetcsv($csv_file);

    if (is_array($csv_row))
    {
      //añadidos al principio del registro la población
      array_unshift($csv_row, $poblacion);
      //y lo guardamos en el archivo final
      fputcsv( $csv_merged_file, $csv_row, ',', '"');
    }
  }
  fclose( $csv_file );

}

fclose($csv_merged_file);

echo "\n\nMerge done -> $merged_csv_filename \n";


 ?>
