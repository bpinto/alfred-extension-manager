<?php

require_once('workflows.php');
$w = new Workflows();

$query = $argv[1];

$json = $w->request("https://raw.github.com/hzlzh/AlfredWorkflow.com/master/workflow-api.json");
$data = json_decode($json);

foreach ($data as $row => $extension) {
  foreach ($extension as $rel => $value) {
    switch ($rel) {
    case "workflow-download-link":
      $link = $value;
      break;
    case "workflow-name":
      $title = $value;
      $uid   = $value;
      break;
    case "workflow-description-small":
      $subtitle = $value;
      break;
    case "workflow-screenshot":
      $icon = 'icon.png';
      break;
    }
  }

  if (!(stripos($title, $query) === false)) {
    $json_array = array(
      "download-link" => $link,
      "title"         => $title
    );
    $json = json_encode($json_array);

    $w->result($uid, $json, $title, $subtitle, $icon);
  }
}

echo $w->toxml();
