<?php

namespace Pam\Model;

use PDO;

/**
 * Class PDOModel
 * @package Pam\Model
 */
class PDOModel implements DatabaseInterface
{
    /**
     * @var PDO
     */
    private $pdo = null;

    /**
     * PDOModel constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function getData(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);
        $PDOStatement->execute($params);

        return $PDOStatement->fetch();
    }

    /**
     * @param string $query
     * @param array $params
     * @return array|mixed
     */
    public function getAllData(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);
        $PDOStatement->execute($params);

        return $PDOStatement->fetchAll();
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool|mixed
     */
    public function setData(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        return $PDOStatement->execute($params);
    }
}
