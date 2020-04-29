<?php
/**
 * Date: 4/29/20
 * @author Patrick Mutwiri
 * @patric_mutwiri
 */

namespace Patricmutwiri\Archive;


class Archive
{
    private $dbs;
    private $tables;
    private $date_from;
    private $date_to;
    private $tstamp;
    private $confs;

    /**
     * Archive constructor.
     */
    public function __construct()
    {
        $this->confs = parse_ini_file("../config/settings.ini",true) ?? null;
        $this->dbs      = getenv('DATABASES');
        $this->tables   = getenv('TABLES');
        $this->tstamp   = date("Ymdhis");

        $from   = getenv('ARCHIVE_FROM');
        $to     = getenv('ARCHIVE_TO');
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
}