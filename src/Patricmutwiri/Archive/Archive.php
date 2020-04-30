<?php
/**
 * Date: 4/29/20
 * @author Patrick Mutwiri
 * @patric_mutwiri
 */

namespace Patricmutwiri\Archive;

use DateTime;

class Archive
{
    protected $dbs;
    protected $tables;
    protected $dates;
    protected $tstamp;
    protected $confs;
    protected $dbconfs;

    /**
     * Archive constructor.
     */
    public function __construct()
    {
        set_time_limit(0);
        try {
            $confs = parse_ini_file("../config/settings.ini",true) ?? null;
        } catch (\Exception $e) {
            $confs = null;
            $msg = "Config file not read. ".$e->getMessage();
            error_log($msg);
            die($msg);
        }
        if (is_null($confs)) {
            $msg = "Configs not found. ";
            error_log($msg);
            die($msg);
        }
        $dateFormat     = $confs['date_format'] ?? "Y-m-d H:i:s";
        $this->confs    = $confs;
        $dbs            = explode(",",$confs['databases']) ?? null;
        $dbs = array_map('strlen',$dbs);
        $dbConfigs = [];
        if(!is_null($dbs)) {
            $dbs = array_unique($dbs);
            foreach ($dbs as $db):
                $dbConf = $confs[$db];
                $tables = array_unique(explode(",",$dbConf["tables"]));
                $tables = array_map('strlen',$tables);
                $keycolumns = array_unique(explode(",",$dbConf["keycolumns"]));
                $keycolumns = array_map('strlen',$keycolumns);
                $dbConfigs[$db] = array(
                    'host'  => $dbConf["host"] ?? null,
                    'user'  => $dbConf["user"] ?? null,
                    'password'  => $dbConf["password"] ?? null,
                    'tables'  => $tables ?? null,
                    'keycolumns'  => $keycolumns ?? null,
                    'db' => $db
                );
            endforeach;
        }
        if(empty($dbConfigs)) {
            die("DB Configs not found. ");
        }
        $from   = $confs["archive_from"] ?? null;
        $to     = $confs["archive_to"] ?? null;
        if(is_null($from) || $this->validateDate($from,$dateFormat)) {
            $err = "archive_from date {$from} fails validation. Either null or not well-formatted. Format set {$dateFormat}; Date given {$from}; ";
            error_log($err);
            die($err);
        }
        if(!is_null($to)) {
            if(!$this->validateDate($to,$dateFormat)) {
                $err = "archive_to date {$from} fails validation. Either null or not well-formatted. Format set {$dateFormat}; Date given {$to}; ";
                error_log($err);
                die($err);
            }
        }
        $archiveDates = array(
            'from'  => date($dateFormat,strtotime($from)),
            'to'    => date($dateFormat,strtotime($from))
        );
        $this->dates = $archiveDates;
        error_log("Archives Dates ".json_encode($archiveDates));
        $this->dbconfs = $dbConfigs;
        $this->tstamp   = date("Ymdhis");

    }

    /*
     * get databases for archiving
     * */
    public function getDatabases()
    {
        return $this->dbs;
    }

    /*
     * get tables for archiving
     * */
    public function getTables()
    {
        return $this->tables;
    }

    public function getName(string $string)
    {
        return $string; // test
    }

    public function confs() {
        return print_r($this->confs);
    }

    public function validHost($host)
    {
        return $this->curlTo($host) ?? false;
    }

    public function curlTo($url,$data=array(),$rq=0) {
        $ch = curl_init();
        $postvars = '';
        if(!empty($data)) {
            foreach($data as $key => $value) {
                $postvars .= $key . "=" . $value . "&";
            }
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST, $rq);                //0 for a get request
        curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        $response = curl_exec($ch);
        if (!empty(curl_errno($ch))) {
            $Errmsg = "Curl error ".curl_errno($ch)." Error Msg ".curl_error($ch);
            error_log($Errmsg);
            return false;
        }
        error_log($response);
        return $response;
        curl_close ($ch);
    }

    function getIp() {
        try {
            $ipserver = "ifconfig.co";
            $response = $this->curlTo($ipserver);
            if(!empty($response)) {
                $response = json_decode($response)->ip;
            }
        } catch (\Exception $e) {
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            }
            $response = $ip;
        }
        error_log("IP ".$response);
        return $response;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function dbCon(){

    }
}