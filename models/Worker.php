<?php
class Worker
{
  // DB Stuff
  private $conn;
  private $table = 'shift';

  // Properties
  public $id;
  public $firstName;
  public $lastName;
  public $birthDate;


  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  //**********  Get Workers **********/
  public function read()
  {
    // Create query
    $query = 'SELECT
        id,
        firstName,
        lastName,
        birthDate
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

  //********** Get Single Worker **********/
  public function read_single()
  {
    // Create query
    $query = 'SELECT
          id,
          firstName,
          lastName,
          birthDate
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
    $this->firstName = $row['firstName'];
    $this->lastName = $row['lastName'];
    $this->birthDate = $row['birthDate'];
  }

  //********** Create Worker **********/
  public function create()
  {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      firstName = :firstName,
      lastName = :lastName,
      birthDate = :birthDate';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->firstName = htmlspecialchars(strip_tags($this->firstName));
    $this->lastName = htmlspecialchars(strip_tags($this->lastName));
    $this->birthDate = htmlspecialchars(strip_tags($this->birthDate));

    // Bind data
    $stmt->bindParam(':firstName', $this->firstName);
    $stmt->bindParam(':lastName', $this->lastName);
    $stmt->bindParam(':birthDate', $this->birthDate);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Update Worker **********/
  public function update()
  {
    // Create Query
    $query = 'UPDATE ' .
      $this->table .
      '
    SET
      firstName = :firstName,
      lastName = :lastName,
      birthDate = :birthDate
      WHERE
      id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->firstName = htmlspecialchars(strip_tags($this->firstName));
    $this->lastName = htmlspecialchars(strip_tags($this->lastName));
    $this->birthDate = htmlspecialchars(strip_tags($this->birthDate));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':firstName', $this->firstName);
    $stmt->bindParam(':lastName', $this->lastName);
    $stmt->bindParam(':birthDate', $this->birthDate);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Delete Worker **********/
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