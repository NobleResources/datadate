<?php

namespace DataDate\Database;

use CI_DB;
use CI_DB_active_record;
use CI_DB_driver;
use CI_DB_result;

class Connection
{
    /**
     * @var CI_DB_driver
     */
    private $ci;

    /**
     * Connection constructor.
     *
     * @param CI_DB_active_record|CI_DB_driver $ci
     */
    public function __construct(CI_DB_driver $ci)
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

        if ($result instanceof CI_DB_result) {
            return $result->result_array();
        }

        return $result;
    }

}