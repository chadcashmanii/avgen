<?php

class dbo extends stdClass {
    private $host;
    private $user;
    private $password;
    private $port;
    private $db;

    public function __construct($host, $db, $user, $password, $port = false) {
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
        $this->port     = $port;
        $this->db       = $db;
    }

    public function run($sql, $output = true) {
        return $this->_run($sql, $output);
    }

    private function _run($sql, $output) {
        $return = false;
        if($this->port) {
            $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db, $this->port);
        } else {
            $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
        }
        $mysqli->set_charset("utf8");
        $result = $mysqli->query($sql);
        if($output) {
            $returnArray = array();
            while($row = $result->fetch_assoc()) {
                $returnArray[] = $row;
            }
            $returns = $returnArray;
            if(is_array($returns) && !empty($returns)) {
                $return = $returns;
            }
        } else {
            $return = true;
        }

        $mysqli->close();
        return $return;
    }

    // todo: have to find/create dbo class/functions for selecting
    /*public function select($sql, $bindString, $bindParams) {
        return $this->_select($sql, $bindString, $bindParams);
    }

    private function _select($sql, $bindString, $bindParams) {
        $return = false;
        if($this->port) {
            $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db, $this->port);
        } else {
            $mysqli = new mysqli($this->host, $this->user, $this->password, $this->db);
        }
        $mysqli->set_charset("utf8");
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param($bindString, $bindParams);
        $stmt->execute();
        $returns = $stmt->fetch();
        if(is_array($returns) && !empty($returns)) {
            $return = $returns;
        }
        $mysqli->close();
        return $return;
    }*/
}