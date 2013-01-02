<?php
/**
 * Class to manage connection
 */

/**
 * Class to manage connection with database. Use PDO connection only.
 *
 * @package core
 * @property PDO connection
 * */

class ApplicationDB
{
    /**
     * PDO instance
     * @static.
     * @var PDO
     */
    private static $connection;

    /**
     * Configuration class instance
     * @var Configuration
     */
    private $configuration;

    /**
     * Construct a Database connection, get all
     *date for connection form config.php file in site root directory*/
    function __construct()
    {
        $this->configuration = new Configuration();

        switch ($this->configuration->db('type')) {
            case "mysql":
                self::$connection = new PDO($this->configuration->db('type') . ":host=" . $this->configuration->db('address') . ";dbname=" . $this->configuration->db('name') . ";charset=" . $this->configuration->db('charset'), $this->configuration->db('user'), $this->configuration->db('password'));
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                break;
            case "pgsql":
                self::$connection = new PDO($this->configuration->db('type') . ":host=" . $this->configuration->db('address') . ";dbname=" . $this->configuration->db('name') . "", $this->configuration->db('user'), $this->configuration->db('password'));
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->exec("SET NAMES " . $this->configuration->db('charset'));
                break;
            case "oracle":
                self::$connection = new PDO("OCI:dbname=" . $this->configuration->db('name') . ";charset=" . $this->configuration->db('charset'), $this->configuration->db('user'), $this->configuration->db('password'));
                break;
        }
    }

    /**
     * Close Database connection*/
    function __destruct()
    {
        self::$connection = null;
    }

    /**
     * Close Database connection*/
    public function  closeDB()
    {
        self::$connection = null;
    }

    /**
     * Create new connection
     * @static
     * @return PDO
     * @throws Exception*/
    public static function connectDB()
    {
        if (!self::$connection) {
            $conn = new ApplicationDB();
            try {
                return $conn->getConnection();
            } catch (PDOException $e) {
                throw new Exception ('Connection error: ' . $e->getMessage());
            }
        } else
            return self::$connection;
    }

    /**
     * Return PDO object
     * @return PDO*/
    public function getConnection()
    {
        return self::$connection;
    }

}
