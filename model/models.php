<?php

  class Database {
    private $pdo = null;
    private $statement = null;

    public function __construct() {
      try {
        $this->pdo = new PDO("mysql:host=localhost;dbname=trax;charset=utf8","root", "Yanka1616", 
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
        ]);
      } catch (Exception $e) { print "Unable to connect to db: " . ($e->getMessage()); }
    }

    // Reset the class properties once we're done using them
    public function __destruct() {
      if ( $this->statement !== null ) { $this->statement = null; }
      if ( $this->pdo !== null ) { $this->pdo = null; }
    }

    public function queryAll( $sql, $condition = null ) {
      $result = false;

      try {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute($condition);
        $result = $this->statement->fetchAll();
      } catch (Exception $e) { print( "Unable to query:" .  $e->getMessage()); }
     // Return the result set obtained from the database
      return $result;
    }

    public function queryOneRow( $sql, $condition = null ) {
      $result = false;

      try {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute($condition);
        $result = $this->statement->fetch();
      } catch (Exception $e) { print "Unable to query for one row: " . $e->getMessage(); }

      return $result;
    }

    public function queryNumRows( $sql, $condition = null ) {
      $result = false;

      try {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute($condition);
        $result = $this->statement->rowCount();
      } catch (Exception $e) { print ( "Unable to get row count: " . $e->getMessage()); }
      
      return $result;
    }

    public function insert( $sql, $condition = null) {
      try {
        $this->statement = $this->pdo->prepare($sql)->execute($condition);
      } catch (Exception $e) { print ( "Unable to insert row: " . $e->getMessage()); }
    }

  } 

?>