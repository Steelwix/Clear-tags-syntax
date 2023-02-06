<?php



class DatabaseManager
{
    protected $database;
    public function __construct()
    {
        try {
            $this->database = new PDO('mysql:host=localhost;dbname=omega', 'maelenphp', 'hkzkwx02');
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            $e = "DatabaseManager can't reach database";
        }
    }
}
