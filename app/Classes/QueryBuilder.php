<?php

namespace App\Classes;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{

    private $pdo;
    private $query;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {

        $this->pdo = $pdo;
        $this->query = $queryFactory;

    }

    public function getAll($table)
    {

        if (empty($table)) {
            return false;
        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);
        $select->where('ID = :ID');
        $select->bindValue('ID', $id);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $select->getBindValues();
        $statement->execute($bind);

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    public function create($table, $arFields)
    {

        if (empty($table) || !is_array($arFields)) {
            return false;
        }

        $arKeys = array_keys($arFields);

        //Sql запрос
        $insert = $this->query->newInsert();
        $insert->into($table);
        $insert->cols($arKeys);
        $insert->bindValues($arFields);

        //Подготавливаем запрос
        $sql = $insert->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $insert->getBindValues();
        $statement->execute($bind);

        return $this->pdo->lastInsertId();

    }

    public function update($table, $id, $arFields)
    {

        if (empty($table) || empty($id) || !is_array($arFields)) {
            return false;
        }

        $arKeys = array_keys($arFields);

        //Sql запрос
        $update = $this->query->newUpdate();
        $update->table($table);
        $update->cols($arKeys);
        $update->where('ID = :ID');
        $update->bindValues(array_merge($arFields, ['ID' => $id]));

        //Подготавливаем запрос
        $sql = $update->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $update->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

    public function delete($table, $id)
    {

        if (empty($table) || empty($id)) {
            return false;
        }

        //Sql запрос
        $delete = $this->query->newDelete();
        $delete->from($table);
        $delete->where('ID = :ID');
        $delete->bindValue('ID', $id);

        //Подготавливаем запрос
        $sql = $delete->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $delete->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

}
