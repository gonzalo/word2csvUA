<?php

require_once 'htmlpurifier-4.8.0-lite/library/HTMLPurifier.auto.php';

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.AllowedElements', 'p,b,i,strong');
$config->set('HTML.AllowedAttributes', '');
$config->set('AutoFormat.RemoveEmpty', true);

$purifier = new HTMLPurifier($config);

//get files to parse
$files = glob('rawhtml/*.{html}', GLOB_BRACE);
foreach ($files as $file) {

  echo "\nCleaning -> $file";

  $file_content = file_get_contents($file, true);
  $clean_html = $purifier->purify($file_content);
  $clean_file = 'cleanhtml/' . basename($file);
  file_put_contents($clean_file , $clean_html);

  echo "\nDone     -> $clean_file";

  //echo "\n$clean_html";



}

echo "\n\n";

?>
