#!/usr/bin/php
<?php
chdir(__DIR__);

require_once('functions.php');

if ($argc !== 2)
    die("This command has to be called with exactly one(!) parameter: the path to the config file.\n");

$configfile = $argv[1];

if (!stream_resolve_include_path($configfile))
    die(sprintf("Missing config file: %s\n", $configfile));
require_once $configfile;


$supported_programs = unserialize(SUPPORTED_PROGRAMS);
$supported_programs_qmarks = implode(',', array_fill(0, count($supported_programs), '?'));

while (true) {
    $pdo = pdo_connect();
    $stm_get_job = $pdo->prepare('SELECT * FROM request_job(?, ?, ARRAY[' . $supported_programs_qmarks . '])');
    $stm_get_job->execute(array_merge(array(MAX_FORKS, HOSTNAME), array_keys($supported_programs)));
    if ($stm_get_job->rowCount() > 0) {
        $job = $stm_get_job->fetch(PDO::FETCH_ASSOC);
        /* we don't want fork to mess with our pdo object. this will cause trouble. */
        unset($pdo, $stm_get_job);

        //works with unix systems
        if (function_exists('pcntl_fork')) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                die('forking failed! quitting.');
            } else if ($pid) {
                //try if we can get another job
                continue;
            } else {
                include "worker-thread.php";
            }
        } 
        //we are in windows, try it a different way
        else {
            $tmpfile = tempnam(sys_get_temp_dir(), "worker");
            file_put_contents($tmpfile, serialize(array('job'=>$job, 'configfile'=>$configfile)));
            exec(sprintf('psexec -d php.exe worker-thread.php "%s"', $tmpfile));
        }
    } else {
        usleep(5 * 1000 * 1000);
    }
}
?>