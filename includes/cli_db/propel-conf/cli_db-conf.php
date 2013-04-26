<?php
require_once __DIR__.'/../../constants.php';
// This file generated by Propel 1.6.8 convert-conf target
// from XML runtime conf file C:\Users\mail_000\Dropbox\uni\bio\s202139\includes\cli_db\config\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'cli_db' => 
    array (
      'adapter' => 'pgsql',
      'connection' => 
      array (
        'dsn' => sprintf('pgsql:host=%s;dbname=%s', DB_SERVER, DB_DB),
        'user' => DB_USERNAME,
        'password' => DB_PASSWORD,
      ),
    ),
    'default' => 'cli_db',
  ),
  'generator_version' => '1.6.8',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-cli_db-conf.php');
return $conf;