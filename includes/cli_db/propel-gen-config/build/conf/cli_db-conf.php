<?php
// This file generated by Propel 1.6.8 convert-conf target
// from XML runtime conf file C:\Users\mail_000\Dropbox\uni\bio\s202139\includes\cli_db\propel-gen-config\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'transcript_db' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=localhost;dbname=my_db_name',
        'user' => 'my_db_user',
        'password' => 'my_db_password',
      ),
    ),
    'default' => 'transcript_db',
  ),
  'generator_version' => '1.6.8',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-cli_db-conf.php');
return $conf;