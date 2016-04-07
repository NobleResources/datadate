<?php

namespace DataDate\Database;

use CI_DB;

class Connection
{
    /**
     * @var \CI_DB_driver
     */
    private $ci;

    /**
     * Connection constructor.
     *
     * @param CI_DB $ci
     */
    public function __construct(CI_DB $ci)
    {
        $this->ci = $ci;
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function runQuery($query)
    {
        $result = $this->ci->query($query);

        if ($result instanceof \CI_DB_result) {
            return $result->result_array();
        }

        return $result;
    }

}