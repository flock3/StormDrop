<?php

namespace Service;

use PDO;

/**
 * @author  Thomas Gray <tom@osg.me>
 */
class ServiceLoader
{
    /**
     * PDO object for db access
     *
     * @var PDO $dataSource
     */
    protected $dataSource;

    /**
     * config array from the config.php file
     * @var array
     */
    protected $config;

    /**
     * array of existing loaded services (key == service name)
     *
     * @var array $services
     */
    protected $services = array();

    /**
     * @var string
     */
    protected $serviceNamespace = 'Service\\';


    /**
     * Constructor accepts our service driven dependencies
     *
     * @param PDO $dataSource
     * @param array $config
     */
    public function __construct($dataSource, $config)
    {
        $this->setDataSource($dataSource);
        $this->setConfig($config);
    }

    /**
     * Returns our current realpath include directory
     * @return string
     */
    protected function getIncludeDir()
    {
        return realpath(__DIR__);
    }

    /**
     * Attempts to retrieve the service name defined in the $serviceName and passes dependencies to setters.
     * @param $serviceName
     * @return \Service\ServiceAbstract
     * @throws \InvalidArgumentException
     */
    public function get($serviceName)
    {
        $class = $this->getServiceNamespace() . $serviceName;

        if(array_key_exists($class, $this->services))
        {
            return $this->services[$class];
        }

        $fileName = $this->getIncludeDir() . '/' . $serviceName . '.php';

        if(!file_exists($fileName))
        {
            throw new \InvalidArgumentException(
                'You asked me to get you service ' . $serviceName . ' which doesn\'t exist in path: '. $fileName
            );
        }

        $service = new $class($this->getDataSource());

        $this->services[$serviceName] = $service;

        return $service;
    }

    /**
     * setDataSource method
     *
     * @param mixed $dataSource
     *
     * @return ServiceLoader
     */
    protected function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    /**
     * getDataSource method
     *
     * @return PDO
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * setConfig method
     *
     * @param array $config
     *
     * @return ServiceLoader
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

    /**
     * setServiceNamespace sets the serviceNamespace property in object storage
     *
     * @param string $serviceNamespace
     * @throws \InvalidArgumentException
     * @return ServiceLoader
     */
    public function setServiceNamespace($serviceNamespace)
    {
        if (empty($serviceNamespace))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' cannot accept an empty string serviceNamespace');
        }
        $this->serviceNamespace = $serviceNamespace;
        return $this;
    }

    /**
     * getServiceNamespace returns the serviceNamespace from the object
     *
     * @return string
     */
    public function getServiceNamespace()
    {
        return $this->serviceNamespace;
    }




}
