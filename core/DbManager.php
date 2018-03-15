<?php

/**
 * Class DbManager
 */
class DbManager
{
    /**
     * @var array
     */
    protected $connections;

    /**
     * @var array
     */
    protected $repository_connection_map = array();

    /**
     * @var array
     */
    protected $repositories;

    /**
     * @param string $name
     * @param array $params
     */
    public function connect(string $name, array $params)
    {
        $params = array_merge(array(
            'dsn' => null,
            'user' => '',
            'password' => '',
            'options' => array()
        ), $params);

        $con = new PDO(
            $params['dns'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $con;
    }

    /**
     * @param string|null $name
     * @return mixed
     */
    public function getConnection(string $name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    /**
     * @param string $repository_name
     * @param string $name
     */
    public function setRepositoryConnectionMap(string $repository_name, string $name)
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * @param string $repository_name
     * @return mixed
     */
    public function getConnectionForRepository(string $repository_name)
    {
        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }

        return $con;
    }

    /**
     * @param $repository_name
     * @return mixed
     */
    public function get($repository_name)
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($con);

            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}