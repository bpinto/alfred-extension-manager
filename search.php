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
      $arg = $value;
      break;
    case "workflow-name":
      $title = $value;
      $uid   = $value;
      break;
    case "workflow-description-small":
      $subtitle = $value;
      break;
    case "workflow-screenshot":
      $icon = $value;
      break;
    }
  }

  if (!(stripos($title, $query) === false)) {
    $w->result($uid, $arg, $title, $subtitle, $icon);
  }
}

echo $w->toxml();
