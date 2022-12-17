<?php

use Dotenv\Dotenv;
use Shield\Database\DB;

require_once __DIR__ . '/../src/Support/helpers.php';
require_once base_path() . 'vendor/autoload.php';
require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

dump(DB::table('city')
    ->where('city_id', '>', '550')
    ->get());

app()->run();