<?php
class Shift
{
  // DB Stuff
  private $conn;
  private $table = 'shift';

  // Properties
  public $id;
  public $label;


  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  //**********  Get Shifts **********/
  public function read()
  {
    // Create query
    $query = 'SELECT
        id,
        label
      FROM
        ' . $this->table . '
      ORDER BY
        id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  //********** Get Single Shift **********/
  public function read_single()
  {
    // Create query
    $query = 'SELECT
          id,
          label
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set properties
    $this->id = $row['id'];
    $this->label = $row['label'];
  }

  //********** Create Shift **********/
  public function create()
  {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      label = :label';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->label = htmlspecialchars(strip_tags($this->label));

    // Bind data
    $stmt->bindParam(':label', $this->label);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Update Shift **********/
  public function update()
  {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
    SET
      label = :label
      WHERE
      id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->label = htmlspecialchars(strip_tags($this->label));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':label', $this->label);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Delete Shift **********/
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}