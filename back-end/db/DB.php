<?php

class DB {
    
    /**
     * 
     * @var PDO
     */
    private static $_pdo;
    
    /**
     * 
     * @return PDO
     */
    public static function getConnection() {
        $iniFile = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/suplosBackEnd/config.ini', true);
        $config = $iniFile['MYSQL'];
        $host = $config['host'];
        $dbName = $config['dbname'];
        $user = $config['user'];
        $password = $config['password'];
        $port = $config['port'];
        $dsn = "mysql:host={$host};dbname=$dbName;port=$port";
        self::$_pdo = new PDO($dsn, $user, $password);
        return self::$_pdo;
    }
}
