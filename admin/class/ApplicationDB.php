<?php
/**
 * Class to manage connection
 */

/**
 * Class to manage connection with database. Use PDO connection only.
 *
 * @package core
 *
 * @property-read $connection its return PDO object
 * */

class ApplicationDB
{
    /**
     * PDO instance.
     * @var PDO
     */
    private $connection;

   /**
    * Construct a Database connection, get all
    *date for connection form config.php file in site root directory*/
    function __construct()
    {
        switch(DB_TYPE){
            case "mysql":
                $this->connection = new PDO(DB_TYPE.":host=".DB_ADDRES.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER,DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
                break;
            case "pgsql":
                $this->connection = new PDO(DB_TYPE.":host=".DB_ADDRES.";dbname=".DB_NAME."", DB_USER,DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
                $this->connection->exec("SET NAMES".DB_CHARSET);
                break;
            case "oracle":
                $this->connection = new PDO("OCI:dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
                break;
        }
    }

   /**
    * Close Database connection*/
    function __destruct()
    {
        $this->connection = null;
    }

   /**
    * Close Database connection*/
    public function  closeDB()
    {
        $this->connection = null;
    }

   /**
    * Create new connection
    *@static
    *@return PDO
    *@throws Exception*/
    public static function connectDB()
    {
        $conn = new ApplicationDB();
            try{
                return $conn->getConnection();
            }
            catch(PDOException $e){
                throw new Exception ('Connection error: '.$e->getMessage());
            }
    }

    /**
     * Return PDO object
     * @return PDO*/
    public function getConnection()
    {
        return $this->connection;
    }

}
