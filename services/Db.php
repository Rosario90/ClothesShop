<?php
class Db
{
    const DBMS_NAME = 'mysql';
    const HOST = 'localhost';
    const DB_NAME = 'shop';

    protected $dsn = self::DBMS_NAME . ':host=' . self::HOST . ';dbname=' . self::DB_NAME;

    protected $login = 'root';
    protected $password = '';
    protected $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );

    protected static $instance = null;

    public $conn;

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance()
    {
        if(is_null(self::$instance)) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    public function getConnection()
    {
        if(is_null($this->conn)) {
            $this->conn = new PDO(
                $this->dsn,
                $this->login,
                $this->password,
                $this->opt
            );
        }
        return $this->conn;
    }

    public function prepare($sql)
    {
        return $this->getConnection()->prepare($sql);
    }

    public function query($sql)
    {
        return $this->getConnection()->query($sql);
    }

    public function execute($sql, $params)
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
    }

    public function fetch($sql, $params)
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function fetchObject($sql, $params, $class)
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = null)
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function fetchObjects($sql, $params, $class)
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class);
        $objects = [];
        while ($obj = $stmt->fetch()){
            $objects[] = $obj;
        }
        return $objects;
    }

}