<?php

namespace App\Classes;

use App\Exception\QueryBuilderException;
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

    /**
     * Получает все записи из таблицы
     * @throws QueryBuilderException
     */
    public function getAll($table)
    {

        if (empty($table)) {

            throw new QueryBuilderException(
                'QueryBuilderException getAll'
            );

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

    /**
     * Получает запись из таблицы по ID
     * @throws QueryBuilderException
     */
    public function getById($table, $id)
    {

        if (empty($table) || empty($id)) {

            throw new QueryBuilderException(
                'QueryBuilderException getById'
            );

        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);
        $select->where('id = :id');
        $select->bindValue('id', $id);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $select->getBindValues();
        $statement->execute($bind);

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * Добавляет новую запись в таблицу
     * @throws QueryBuilderException
     */
    public function create($table, $arFields)
    {

        if (empty($table) || !is_array($arFields)) {

            throw new QueryBuilderException(
                'QueryBuilderException create'
            );

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

    /**
     * Обновляет запись в таблице по ID
     * @throws QueryBuilderException
     */
    public function update($table, $id, $arFields)
    {

        if (empty($table) || empty($id) || !is_array($arFields)) {

            throw new QueryBuilderException(
                'QueryBuilderException update'
            );

        }

        $arKeys = array_keys($arFields);

        //Sql запрос
        $update = $this->query->newUpdate();
        $update->table($table);
        $update->cols($arKeys);
        $update->where('id = :id');
        $update->bindValues(array_merge($arFields, ['id' => $id]));

        //Подготавливаем запрос
        $sql = $update->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $update->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

    /**
     * Удаляет запись из таблицы по ID
     * @throws QueryBuilderException
     */
    public function delete($table, $id)
    {

        if (empty($table) || empty($id)) {

            throw new QueryBuilderException(
                'QueryBuilderException delete'
            );

        }

        //Sql запрос
        $delete = $this->query->newDelete();
        $delete->from($table);
        $delete->where('id = :id');
        $delete->bindValue('id', $id);

        //Подготавливаем запрос
        $sql = $delete->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $delete->getBindValues();
        $statement->execute($bind);

        return $statement->rowCount();

    }

    /**
     * Получает профиль по ID пользователя
     * @param $table
     * @param $id
     * @return mixed
     * @throws QueryBuilderException
     */
    public function getProfileByUserId($table, $id)
    {

        if (empty($table) || empty($id)) {

            throw new QueryBuilderException(
                'QueryBuilderException getProfileByUserId'
            );

        }

        //Sql запрос
        $select = $this->query->newSelect();
        $select->cols(['*']);
        $select->from($table);
        $select->where('user_id = :user_id');
        $select->bindValue('user_id', $id);

        //Подготавливаем запрос
        $sql = $select->getStatement();
        $statement = $this->pdo->prepare($sql);

        //Выполняем запрос
        $bind = $select->getBindValues();
        $statement->execute($bind);

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

}
