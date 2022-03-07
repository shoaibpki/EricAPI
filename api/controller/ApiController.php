<?php
class Service
{
    //DB stuff
    private $conn;
    private $table = 'services';

    //Service Properties
    public $id;
    public $ref;
    public $centre;
    public $services;
    public $countryCode;

    // constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //   Get Services
    public function read()
    {
        //create query
        $query = 'SELECT
                id,
                ref,
                centre,
                services,
                countrycode
            FROM
                ' . $this->table;

        //prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute qurey
        $stmt->execute();
        return $stmt;
    }

    // Get specifice Service
    public function read_single()
    {
        //create query
        $query = 'SELECT
                id,
                ref,
                centre,
                services,
                countrycode
            FROM
                ' . $this->table .
            " WHERE 
                countrycode = ?";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        // bind parameter
        $stmt->bindParam(1, $this->countryCode);

        // Execute qurey
        $stmt->execute();

        return $stmt;
    }

    // create Service
    public function create()
    {
        $query = 'INSERT INTO ' .
            $this->table .
            ' SET
            ref = :ref,
            centre = :centre,
            services = :services,
            countrycode = :countrycode';

        // Prepare statement
        $stmt =  $this->conn->prepare($query);

        // clean data
        $this->ref = htmlspecialchars(strip_tags($this->ref));
        $this->centre = htmlspecialchars(strip_tags($this->centre));
        $this->services = htmlspecialchars(strip_tags($this->services));
        $this->countrycode = htmlspecialchars(strip_tags($this->countryCode));

        // bind parameters 
        $stmt->bindParam(':ref', strtoupper($this->ref));
        $stmt->bindParam(':centre', $this->centre);
        $stmt->bindParam(':services', $this->services);
        $stmt->bindParam(':countrycode', $this->countryCode);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        // printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Service
    public function update()
    {
        $query = 'UPDATE ' .
            $this->table .
            ' SET
                centre = :centre,
                services = :services,
                countrycode = :countrycode
            WHERE 
                ref = :ref';

        // Prepare statement
        $stmt =  $this->conn->prepare($query);
        // clean data
        $this->centre = htmlspecialchars(strip_tags($this->centre));
        $this->services = htmlspecialchars(strip_tags($this->services));
        $this->countryCode = htmlspecialchars(strip_tags($this->countryCode));
        $this->ref = htmlspecialchars(strip_tags($this->ref));

        // bind parameters 
        $stmt->bindParam(':centre', $this->centre);
        $stmt->bindParam(':services', $this->services);
        $stmt->bindParam(':countrycode', $this->countryCode);
        $stmt->bindParam(':ref', $this->ref);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        echo $this->ref;
        //  Print error if something goes wrong
        // printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
