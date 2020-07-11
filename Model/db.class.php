<?php

    /**
     *Db file Created by Abdul Aziz
     */
    class Database
    {

        private $_dbh;
        private $_stmp;

        function __construct()
        {
            $this->_dbh=new PDO("mysql:host=localhost;dbname=cvmaker","root","");
        }
        function query($query="") {
            $this->_stmp = $this->_dbh->prepare($query);
        }
        function bind($placeholder="",$value="") {

            $this->_stmp->bindvalue($placeholder,$value);

        }
        function run() {
            return $this->_stmp->execute();
        }

        function all() {
            $this->run();
            return $this->_stmp->fetchall();
        }
        function single() {
            $this->run();
            return $this->_stmp->fetch();
        }
    }

?>