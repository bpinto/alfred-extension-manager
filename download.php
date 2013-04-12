<?php

require_once('workflows.php');
$w = new Workflows();

$query = $argv[1];
$data = json_decode($query, true);

$download_link  = $data['download-link'];
$basename       = pathinfo($download_link, PATHINFO_BASENAME);
$file_name      = "/tmp/$basename";

$file_data = file_get_contents($download_link);

$handle = fopen($file_name, 'x+');
fclose($handle);

$downloaded = file_put_contents($file_name, $file_data);
if($downloaded > 0) {
  echo 'Datei wurde erfolgreich heruntergeladen!<br>';
}

exec('open '. $file_name, $extract);

if($extract > 0) {
  echo 'Datei wurde entpackt';
}
