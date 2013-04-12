<?php

require_once('workflows.php');
$w = new Workflows();

$query = $argv[1];
$data = json_decode($query, true);

$download_link  = $data['download-link'];
$file_name      = "/tmp/workflow.alfredworkflow";

$file_data = @file_get_contents($download_link);

if ($file_data) {
  $handle = @fopen($file_name, 'x');
  @fclose($handle);

  $downloaded = @file_put_contents($file_name, $file_data);
  if($downloaded > 0) {
    exec('open '. $file_name, $extract);
  } else {
    echo "Download failed.";
  }
} else {
  echo "Workflow temporarily unavailable";
}

