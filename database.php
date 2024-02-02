<?php

class DatabaseWrapper {
    private $db_host;
    private $db_user;
    private $db_password;
    private $db_name;
    private $mysql;

    public function __construct($host, $user, $password, $db) {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db_name = $db;

        $this->connect();
    }

    private function connect() {
        $this->mysql = @new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);

        if ($this->mysql->connect_error) {
            echo 'Errno: ' . $this->mysql->connect_errno;
            echo '<br>';
            echo 'Error: ' . $this->mysql->connect_error;
            exit();
        }
    }

    public function query($sql) {
        return $this->mysql->query($sql);
    }

    public function select($table, $columns = '*', $where = '') {
        $sql = "SELECT $columns FROM $table";
        if ($where != '') {
            $sql .= " WHERE $where";
        }
        return $this->query($sql);
    }

    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($sql);
    }

    public function update($table, $data, $where) {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key='$value',";
        }
        $set = rtrim($set, ',');
        $sql = "UPDATE $table SET $set WHERE $where";
        return $this->query($sql);
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql);
    }

    public function truncate($table) {
        $sql = "TRUNCATE TABLE $table";
        return $this->query($sql);
    }

    public function fetchAssoc($result) {
        return $result->fetch_assoc();
    }

    public function fetchAll($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function escapeString($value) {
        return $this->mysql->real_escape_string($value);
    }
}

$database = new DatabaseWrapper('localhost', 'root', 'root', 'InfSys');

// $result = $database->select('users', '*', 'id=10');
// $data = $database->fetchAssoc($result);

// $insertData = array('username' => 'newuser', 'password' => 'newpassword', 'email' => 'newuser@example.com');
// $database->insert('users', $insertData);

// $updateData = array('password' => 'newpassword123');
// $database->update('users', $updateData, "username='newuser'");

$database->delete('Users', 'id=19');

if ($data) {
  echo "Information:<br>";
  foreach ($data as $key => $value) {
      echo "$key: $value<br>";
  }
} else {
  echo "Data not found.";
}

