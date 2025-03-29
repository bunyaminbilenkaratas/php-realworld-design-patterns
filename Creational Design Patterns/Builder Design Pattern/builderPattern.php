<?php

class SQLQuery {
    public $select = [];
    public $from = "";
    public $conditions = [];
    public $orderBy = "";
    public $limit = "";

    public function getQueryString(): string {
        $query = "SELECT " . (empty($this->select) ? "*" : implode(", ", $this->select));
        $query .= " FROM " . $this->from;
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }
        if (!empty($this->orderBy)) {
            $query .= " ORDER BY " . $this->orderBy;
        }
        if (!empty($this->limit)) {
            $query .= " LIMIT " . $this->limit;
        }

        return $query;
    }
}

interface SQLQueryBuilder {
    public function reset(): void;
    public function select(array $columns): void;
    public function from(string $table): void;
    public function where(string $condition): void;
    public function orderBy(string $order): void;
    public function limit(int $limit, int $offset = 0): void;
    public function getQuery(): SQLQuery;
}

class ConcreteSQLQueryBuilder implements SQLQueryBuilder {
    private $query;

    public function __construct(){
        $this->reset();
    }

    public function reset(): void {
        $this->query = new SQLQuery();
    }

    public function select(array $columns): void {
        $this->query->select = $columns;
    }

    public function from(string $table): void {
        $this->query->from = $table;
    }

    public function where(string $condition): void {
        $this->query->conditions[] = $condition;
    }

    public function orderBy(string $order): void {
        $this->query->orderBy = $order;
    }

    public function limit(int $limit, int $offset = 0): void {
        $this->query->limit = ($offset > 0 ? $offset . ", " : "") . $limit;
    }

    public function getQuery(): SQLQuery {
        $builtQuery = $this->query;
        $this->reset();
        return $builtQuery;
    }
}

class SQLQueryDirector {
    private $builder;

    public function setBuilder(SQLQueryBuilder $builder): void {
        $this->builder = $builder;
    }

    public function buildSelectAll(string $table): void {
        $this->builder->reset();
        $this->builder->select(["*"]);
        $this->builder->from($table);
    }

    public function buildSelectWithConditions(
        string $table,
        array $conditions,
        array $colums = ["*"],
        string $orderBy = "",
        int $limit = 0,
        int $offset = 0,
    ): void {
        $this->builder->reset();
        $this->builder->select($colums);
        $this->builder->from($table);
        foreach ($conditions as $condition) {
            $this->builder->where($condition);
        }
        if (!empty($orderBy)) {
            $this->builder->orderBy($orderBy);
        }
        if ($limit > 0) {
            $this->builder->limit($limit, $offset);
        }
    }
}

//Usage
$builder = new ConcreteSQLQueryBuilder();

$director = new SQLQueryDirector();
$director->setBuilder($builder);

$director->buildSelectAll("users");
$query1 = $builder->getQuery();
echo "Query 1 : " . $query1->getQueryString() . PHP_EOL;

$director->buildSelectWithConditions(
    "orders",
    ["status = 'pending'", "total > 100"],
    ["id", "name"],
    "created_at DESC",
    10
);
$query2 = $builder->getQuery();
echo "Query 2 : " . $query2->getQueryString() . PHP_EOL;
