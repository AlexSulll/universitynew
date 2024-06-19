<?php

namespace app\thesaurus;
use Exception;
use PDO;
use PDOException;

class DataBase {

    public PDO $pdo;
    private const DATABASEHOST = "127.0.0.1";
    private const DATABASENAME = "oasu";
    private const DATABASEUSERNAME = "root";
    private const DATABASEPASSWORD = "passbd";
    private const DATABASEPORT = 3306;

    /**
     * @throws Exception
     */
    public function __construct() {
        $this->connectToDataBase();
    }

    /**
     * @throws Exception
     */
    public function connectToDataBase(): void
    {

        $dataBaseHost = self::DATABASEHOST;
        $dataBaseName = self::DATABASENAME;
        $dataBaseUsername = self::DATABASEUSERNAME;
        $dataBasePassword = self::DATABASEPASSWORD;
        $dataBasePort = self::DATABASEPORT;

        try {
            $this->pdo = new PDO("mysql:host=$dataBaseHost;dbname=$dataBaseName;port=$dataBasePort",$dataBaseUsername, $dataBasePassword);
        } catch (PDOException $exception) {
            throw new Exception("Ошибка при подключении к базе данных");
        }

    }
}
