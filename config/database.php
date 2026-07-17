<?php

define('DB_HOST', EnvLoader::get('DB_HOST', 'localhost'));
define('DB_PORT', (int) EnvLoader::get('DB_PORT', 3306));
define('DB_NAME', EnvLoader::get('DB_NAME', 'shola_ghar'));
define('DB_USER', EnvLoader::get('DB_USER', 'root'));
define('DB_PASS', EnvLoader::get('DB_PASS', ''));
define('DB_CHARSET', EnvLoader::get('DB_CHARSET', 'utf8mb4'));
define('DB_COLLATION', EnvLoader::get('DB_COLLATION', 'utf8mb4_unicode_ci'));

define('DB_DRIVER', 'mysql');
define('DB_PREFIX', EnvLoader::get('DB_PREFIX', 'sg_'));
