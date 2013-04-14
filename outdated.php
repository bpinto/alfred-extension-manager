<?php

require_once('workflows.php');
$w = new Workflows();

$filepath = $w->path()."/"."info.plist";

exec( 'defaults read "'. $filepath .'" '.name, $out );

$title = str_replace(' ', '_', $out[0]);
$title = strtolower($title);
echo($w->get($title, 'settings.plist'));
