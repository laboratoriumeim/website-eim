<?php
require 'db.php';
$ku = array_map(function($f){return 'event/kuliah_umum/'.basename($f);}, glob('event/kuliah_umum/*.*'));
$pt = array_map(function($f){return 'event/eim_panti26/'.basename($f);}, glob('event/eim_panti26/*.*'));
$pdo->exec("UPDATE events SET image='".json_encode($ku)."' WHERE title='Kuliah Umum Cloud Computing'");
$pdo->exec("UPDATE events SET image='".json_encode($pt)."' WHERE title='EIM Berbagi Panti 2026'");
echo 'Images fixed.';
