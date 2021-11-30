<?php

class DB {

    protected mysqli $connection;
    protected object $query;
    protected bool $queryClosed = true;
    protected bool $showErrors = true;

    public function __construct($dbHost, $dbUser, $dbPassword, $dbName) {
        $this->connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        if ($this->connection->connect_error) {
            $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
        }
    }

    public function query($stmt): object {
        if (!$this->queryClosed) {
            $this->query->close();
        }

        if ($this->connection->prepare($stmt)) {
            $this->query = $this->connection->prepare($stmt);

            // If more than 1 argument is passed to the function, it is prepared statement
            if (func_num_args() > 1) {
                $args = func_get_args();
                $args = array_slice($args, 1);
                $argsArray = [];
                $types = '';

                foreach ($args as $arg) {
                    if (is_array($arg)) {
                        $argsArray = &$arg;
                        foreach ($arg as $arrArg) {
                            $types .= $this->_gettype($arrArg);
                        }
                    } else {
                        $argsArray[] = &$arg;
                        $types .= $this->_gettype($arg);
                    }
                }

                // Put types on the beginning of an array and then call 'bind_param' with this array
                array_unshift($argsArray, $types);
                call_user_func_array(array($this->query, 'bind_param'), $argsArray);
            }

            // Execute query
            $this->query->execute();

            if ($this->query->errno) {
                $this->error('Unable to process MySQL query. Check your params - ' . $this->query->error);
            }

            $this->queryClosed = false;

        } else {
            $this->error('Unable to prepare MySQL statement. Check your syntax - ' . $this->connection->error);
        }

        // Return object - results ($query)
        return $this;
    }

/*    public function xd() {
        $argsArray = ['xd'];
        $metadata = $this->query->result_metadata();
        foreach ($metadata->fetch_field() as $field) {
            $argsArray = $field->name;
        }
        print_r($argsArray);

        return $argsArray;
    }*/

    public function fetchAll(): array {
        $results = $this->query->get_result();
        $this->query->close();
        $this->queryClosed = true;

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchArray(): array {
        $results = $this->query->get_result();
        $this->query->close();
        $this->queryClosed = true;

        $allRows = [];
        // Get all rows
        while($row = $results->fetch_array(MYSQLI_BOTH)){
            $allRows[] = $row;
        }

        return $allRows;
    }

    public function numRows() {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    public function affectedRows() {
        return $this->query->affected_rows;
    }

    public function lastInsertID(): int {
        return $this->connection->insert_id;
    }

    protected function error($error) {
        if ($this->showErrors) {
            exit($error);
        }
    }

    private function _gettype($var): string {
        if (is_string($var)) return 's';
        if (is_float($var)) return 'd';
        if (is_int($var)) return 'i';
        return 'b';
    }
}