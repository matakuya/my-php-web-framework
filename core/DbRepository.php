<?php


class DbRepository
{
    /**
     * @var PDO
     */
    protected $con;

    /**
     * DbRepository constructor.
     * @param PDO $con
     */
    public function __construct(PDO $con)
    {
        $this->setConnection($con);
    }

    /**
     * @param $con
     */
    public function setConnection($con)
    {
        $this->con = $con;
    }

    /**
     * @param $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute($sql, $params = array())
    {
        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function fetch($sql, $params = array())
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, $params = array())
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}