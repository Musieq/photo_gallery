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

        } else {
            $this->error('Unable to prepare MySQL statement. Check your syntax - ' . $this->connection->error);
        }

        return $this;
    }

    public function error($error) {
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
