<?php

namespace Pam\Model;

use PDO;

/**
 * Class PDODatabase
 * @package Pam\Model
 */
class PDODatabase implements DatabaseInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * PDODatabase constructor.
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
    public function result(string $query, array $params = [])
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
    public function results(string $query, array $params = [])
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
    public function action(string $query, array $params = [])
    {
        $PDOStatement = $this->pdo->prepare($query);

        return $PDOStatement->execute($params);
    }
}

