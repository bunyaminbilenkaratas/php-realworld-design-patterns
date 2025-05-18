<?php

interface  DatabaseInterface
{
    public function query($sql);
}

class HeavyDatabase implements DatabaseInterface {
    public function __construct()
    {
        echo "Connecting to the database...\n";
    }

    public function query($sql)
    {
        echo "Executing query: $sql\n";
        sleep(1);
        return "Result of '$sql'";
    }
}

class LazyDatabaseProxy implements DatabaseInterface {
    private ?HeavyDatabase $realDb = null;

    public function query($sql)
    {
        if ($this->realDb === null) {
            $this->realDb = new HeavyDatabase();
        }
        return $this->realDb->query($sql);
    }
}

$db = new LazyDatabaseProxy();
echo $db->query("SELECT * FROM users") . "\n";
