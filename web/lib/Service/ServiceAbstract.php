<?php

namespace Service;

use PDO;

abstract class ServiceAbstract
{
    const STATUS_ACTIVE = 1;
    const STATUS_IGNORED = 3;
    const STATUS_DELETED = 2;
    const STATUS_DISMISSED = 4;
    const STATUS_UNAVAILABLE = 5;

    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var PDO $pdo
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $config;


    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->setPdo($pdo);
    }

    /**
     * setPdo method
     *
     * @param \PDO $pdo
     *
     * @return ServiceAbstract
     */
    protected function setPdo($pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * getPdo method
     *
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->pdo;
    }

    /**
     * setConfig method
     *
     * @param array $config
     *
     * @return ServiceAbstract
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * getConfig method
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
