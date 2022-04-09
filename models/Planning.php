<?php
class Planning
{
  // DB stuff
  private $conn;
  private $table = 'posts';

  // Post Properties
  public $id;
  public $worker_id;
  public $worker_firstName;
  public $worker_lastName;
  public $shift_id;
  public $shift_label;
  public $day;


  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  //********** Get Plannings **********/
  public function read()
  {
    // Create query
    $query = 'SELECT w.firstName as first_name, w.lastName as last_name,
                     s.label as shift,
                     p.day, p.worker_id, p.shift_id
              FROM shift s
              INNER JOIN(
                        worker w 
                        INNER JOIN ' . $this->table . ' p
                        ON w.id = p.worker_id)
              ON s.id=p.shift_id
              ORDER BY p.id DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  //********** Get Single Planning **********/
  public function read_single()
  {
    // Create query
    $query = 'SELECT w.firstName as first_name, w.lastName as last_name,
                     s.label as shift,
                     p.day, p.worker_id, p.shift_id
              FROM shift s
              INNER JOIN(
                        worker w 
                        INNER JOIN ' . $this->table . ' p
                        ON w.id = p.worker_id)
              ON s.id=p.shift_id
              WHERE
                p.id = ?
              LIMIT 0,1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->worker_id = $row['worker_id'];
    $this->shift_id = $row['shift_id'];
    $this->day = $row['day'];
    $this->worker_firstName = $row['first_name'];
    $this->worker_lastName = $row['last_name'];
    $this->shift_label = $row['shift'];
  }

  //********** Create Planning **********/
  public function create()
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' 
              SET 
                worker_id = :worker_id, 
                shift_id = :shift_id, 
                day = :day';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->worker_id = htmlspecialchars(strip_tags($this->worker_id));
    $this->shift_id = htmlspecialchars(strip_tags($this->shift_id));
    $this->day = htmlspecialchars(strip_tags($this->day));

    // Bind data
    $stmt->bindParam(':worker_id', $this->worker_id);
    $stmt->bindParam(':shift_id', $this->shift_id);
    $stmt->bindParam(':day', $this->day);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Update Planning **********/
  public function update()
  {
    // Create query
    $query = 'UPDATE ' . $this->table . '
              SET 
                worker_id = :worker_id, 
                shift_id = :shift_id, 
                day = :day
              WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->worker_id = htmlspecialchars(strip_tags($this->worker_id));
    $this->shift_id = htmlspecialchars(strip_tags($this->shift_id));
    $this->day = htmlspecialchars(strip_tags($this->day));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':worker_id', $this->worker_id);
    $stmt->bindParam(':shift_id', $this->shift_id);
    $stmt->bindParam(':day', $this->day);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  //********** Delete Planning **********/
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function check_worker_shift()
  {
    // Create query
    $query = 'SELECT w.firstName as first_name, w.lastName as last_name,
                     s.label as shift,
                     p.day, p.worker_id, p.shift_id
              FROM shift s
              INNER JOIN(
                        worker w 
                        INNER JOIN ' . $this->table . ' p
                        ON w.id = p.worker_id)
              ON s.id=p.shift_id
              WHERE
                p.worker_id = :worker_id                
                AND
                p.day = :day';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(':worker_id', $this->worker_id);
    $stmt->bindParam(':day', $this->day);

    // Execute query
    $stmt->execute();

    // Check the existence of a planning with same worker and same day
    if ($stmt->fetch(PDO::FETCH_ASSOC))
      return false;
    else
      return true;
  }
}
