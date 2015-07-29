<?php
require_once('server.php');

abstract class DBModel {
    private static $db_host = DB_HOST;
    private static $db_user = DB_USER;
    private static $db_pass = DB_PASS;
    protected $db_name = DB_NAME;
    protected $query;
    protected $rows = array();
    private $conn;
    public $mensaje = "hecho";
   
    abstract protected function get();

    abstract protected function set();

    abstract protected function edit();

    abstract protected function delete();

    //conectar ala base de datos
    private function open_connection() {
        $this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
    }

    private function close_conection() {
        $this->conn->close();
    }

    //ejecuta un query simple del tipo inset,delete,update
    protected function insert_update($keys, $table, $where = "") {
        $rowsUpdated = array();
        foreach ($keys as $row => $value) {
            array_push($rowsUpdated, "'" . trim($row) . "'=" . "'" . $value . "'");
        }
        $values = implode(",", $rowsUpdated);
        if (isset($where) and $where != "") {
            $this->query = "UPDATE $table SET $values WHERE $where";
        } else {
            $this->query = "INSERT INTO $table SET $values";
        }
        $this->open_connection();
        $result = $this->conn->query($this->query);
        $this->close_conection();
        return $result;
    }

    //Traer resuktadis de una consulta en un array
    protected function get_result_query() {
        $this->open_connection();
        $result = $this->conn->query($this->query);
        while ($this->rows[] = $result->fetch_assoc());
        $result->close();
        $this->close_conection();
        array_pop($this->rows);
    }
    
    protected function get_all_results_query() {
        $this->rows=array();
        $this->open_connection();
        $result = $this->conn->query($this->query);
        while ($row = $result->fetch_assoc()) {
            array_push($this->rows, $row);
        }
        $result->close();
        $this->close_conection();
    }

}

?>