<?php

class Logger {

    public static function log($message = "") {

        self::write_to_file(LoggerType::LOG, $message);
    }

    public static function error($message = "") {
        self::write_to_file(LoggerType::ERROR, $message);
    }

    private static function write_to_file($log_type = -1, $message = "") {

        $filename = "";
        $curr_date = date("d-m-Y");
        $log_curr_time = date("d-m-Y H:i:s a");

        if (!is_dir(LOGS_FOLDER_PATH)) {
            mkdir(LOGS_FOLDER_PATH);
        }

        switch ($log_type) {
            case LoggerType::LOG:
                $filename = LOGS_FOLDER_PATH."log_".$curr_date.".txt";
                break;

            case LoggerType::ERROR:
                $filename = LOGS_FOLDER_PATH."error.txt";
                break;
            
            default:
                break;
        }

        if (empty($filename)) return;

        try {

            $log_file = fopen($filename, "a");
            fwrite($log_file, "[{$log_curr_time}]: ".$message.PHP_EOL);
            fclose($log_file);

        } catch (Exception $exception) {
            return;
        }
    }
}