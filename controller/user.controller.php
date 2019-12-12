<?php 
  // Start the session
  session_start();

  class Users extends Database {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }
  
    public function processLogin() {
      // -- PROCESS LOGIN FORM --

      if ( isset($_POST['login'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($this->loginUser($username, $password)) {
          // Upon successful login
          header("Location: view/dashboard.php");
        } else { return false; }
      }

      // -- PROCESS FORGOT PASSWORD FORM --
      if ( isset ($_POST['resetPassword'])) {
        // Send user reset email

        // Show message on login form of email sent to reset password
      }
      // -- START REGISTER FORM --

    }

    public function sessionCheck( $timeout ) {
      // Upon user login, session variable is initiated with current time. Here we parse current time, with when user
      // logged in and determine if we need to destroy the session.
      if ( isset ( $timeout ) ) {
        $timeDifference = time() - $timeout;
        // Check if session is older that 1500 seconds (25min)
        if ( $timeDifference > 1500 ) {
          session_destroy();
          header ("Location: ../index.php");
        }
        
        // Return the time the session has been alive
        return $timeDifference;

      } else { header("Location: ../index.php"); } 
    }

    public function doesUserExist($username) {
      $queryResult = $this->db->queryNumRows("SELECT * FROM `users` WHERE `username` = '" . $username . "'");
      // If a user was found to have the username requested, return true
      if ( $queryResult > 0 ) {
        return true;
      } else {
        return false;
      }
    }

    public function loginUser($username, $password) {
      // Check if the user exists
      $userData = $this->db->queryOneRow("SELECT * FROM `users` WHERE `username` = '" . $username . "' AND `password` = '" . $password ."'");
      
      // If we return data, set the session instances
      if ( !empty( $userData ) ) {
        $_SESSION['login'] = true;
        $_SESSION['uid'] = $userData['id'];
        $_SESSION['username'] = $userData['username'];
        $_SESSION['firstName'] = $userData['first_name'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['timeout'] = time();

        return true;
      } else {
        return false;
      }
      
    }

    public function registerNewUser($firstName, $lastName, $username, $password, $email) {
      // Check if the user already exists
      $userExist = $this->doesUserExist($username);
      if ( $userExist ) {
        return false;
      } else {
        /* If the user doesn't exist - go ahead and create the user */
          $userData = [ 'firstName' => $firstName, 
                        'lastName'  => $lastName, 
                        'username'  => $username,
                        'password'  => $password,
                        'email'     => $email ];
          $sql = ( "INSERT INTO `users` (`first_name`, `last_name`, `username`, `password`, `email`)
                    VALUES ( :firstName, :lastName, :username, :password, :email)");
          $registerUser = $this->db->insert($sql, $userData);
        return true;
      }
    }

    public function userLogout() {
      session_unset();
      header("Location:../index.php");
    }

  }

?>