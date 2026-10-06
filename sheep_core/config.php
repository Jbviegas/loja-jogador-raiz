<?php

date_default_timezone_set('America/Sao_Paulo');

// =====================
// CARREGA O .ENV
// =====================
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// =====================
// CONFIGURAÇÕES DO SITE
// =====================
define('SHEEP_URL', 'jogadorraiz.com.br');

// =====================
// CONFIGURAÇÕES DO BANCO
// =====================
define('SHEEP_HOST', $_ENV['DB_HOST']);
define('SHEEP_PORT', $_ENV['DB_PORT']);
define('SHEEP_USER', $_ENV['DB_USER']);
define('SHEEP_SENHA', $_ENV['DB_PASS']);
define('SHEEP_BD', $_ENV['DB_NAME']);
define('SHEEP_TIPO_BANCO', 'mysql');

require_once('includes.php');
