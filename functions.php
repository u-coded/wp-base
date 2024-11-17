<?php
$pattern = TEMPLATEPATH . '/functions/*.php';
foreach (glob($pattern) as $filename) {
  require_once($filename);
}
