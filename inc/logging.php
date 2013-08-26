<?php
//Multiline error log class
// ersin güvenç 2008 eguvenc@gmail.com
//For break use "\n" instead '\n'

Class log {
    //
    const USER_ERROR_DIR = 'Site_User_errors.log';
    const GENERAL_ERROR_DIR = 'Site_General_errors.log';

    /*
     User Errors...
     */
    public function user($msg) {
        $date = date('d.m.Y h:i:s');
        $log = " |  Date:  " . $date . "  |  Msg:  " . $msg . "\n";
        error_log($log, 3, self::USER_ERROR_DIR);
    }

    /*
     General Errors...
     */
    public function general($msg) {
        $date = date('d.m.Y h:i:s');
        $log = $msg . "   |  Date:  " . $date . "\n";
        error_log($msg . "   |  Tarih:  " . $date, 3, self::GENERAL_ERROR_DIR);
    }

}

$log = new log();
//$log -> user($msg, $username);
//use for user errors
//$log->general($msg); //use for general errors
?>