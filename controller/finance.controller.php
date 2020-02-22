<?php

    class Finance extends Database {
      private $dbHandle = null;

      public function __construct() {
        $this->dbHandle = new Database();
      }

      public function processFinanceInput() {
        // Make sure that there is some kind of validation for selecting financeType so income isn't expensed accidentally
        if (isset ( $_POST['submitFinanceRecord'])) {
          // Request insert of record based on parameters passed in from the form
          $transactionName = $_POST['transactionName'];
          $amount = $_POST['amount'];
          $userId = $_SESSION['uid'];
          $financeType = $_POST['financeType'];
          $financeCategory;

          // If financeCategory is not set, it means we have a request to record an income record so we set it
          // manually to income for the time
          // If it is set, the request is for an expense, which will require a category be associated with it
          if ( $_POST['financeCategory'] != null ) {
            $financeCategory = $_POST['financeCategory'];
          } else {
            $financeCategory = 'income';
          }

          $this->insertFinanceRecord($transactionName, $amount, $userId, $financeType, $financeCategory);
        }

        if ( isset( $_POST['userLogout'] )) {
          print 'logout requested';
        }
      }

      public function getFinanceData( $userId ) {
        // Query for the complete expense dataset
        $dataSet = $this->dbHandle->queryAll("SELECT * FROM `finance` WHERE `user_id` = " . $userId . " ORDER BY `timestamp` DESC");

        return $dataSet;
      }

      public function getYearsData( $userId ) {
        $dataSet = $this->dbHandle->queryAll("SELECT  `timestamp` FROM `finance` WHERE `user_id` = " . $userId );

        return $dataSet;
      }

      public function getEmailData( $userId ) {
        // Query for the complete expense dataset
        $email = $this->dbHandle->queryOneRow("SELECT `email` FROM `users` WHERE `id` = " . $userId."");

        return $email;
      }

      public function getSumYearly( $financeType, $userId ) {
        // Set today's year to query
        $year = date('Y');

        $sql = "SELECT ROUND(SUM(`amount`), 2) AS sum FROM `finance` WHERE `timestamp` LIKE  '%{$year}%' AND `finance_type` = '{$financeType}' AND `user_id` = {$userId} ";
        $yearlySum = $this->dbHandle->queryOneRow($sql);

        if ( !empty ($yearlySum) ) {
          return number_format( $yearlySum['sum'], 2, '.', ',' );
        } else {
          return false;
        }
      }

      public function getCurrentMonthFinanceRecords() {
        $month = date('Y-m');
        $sql = ("SELECT * FROM `finance` WHERE `timestamp` LIKE '%{$month}%' ORDER BY `timestamp` DESC;");
        $monthlyRecords = $this->dbHandle->queryAll($sql);

        return $monthlyRecords;
      }

      public function insertFinanceRecord($transactionName, $amount, $userId, $financeType, $financeCategory) {
        $financeData = [  'transactionName' => $transactionName,
                          'amount' => $amount,
                          'userId' => $userId,
                          'financeType' => $financeType,
                          'financeCategory' => $financeCategory ];

        // Since the form input automatically select income, we'll always have a default value for transactionType
        // so we can prepare the query in a way that will always be based on the parameters being passed in
        $sql = "INSERT INTO `finance` (`transaction_name`, `amount`, `user_id`, `category`, `finance_type`) 
                VALUES (:transactionName, :amount, :userId, :financeCategory, :financeType)";

        // Execute the insertquery
        $this->dbHandle->insert($sql, $financeData);

        return true;
      }

      // FUNCTIONS BELOW ARE USED TO PRINT DATA GATHERED IN A MANNER PRESENTED TO THE DASHBOARD

      function showMonthylRecords() {
        $data = $this->getCurrentMonthFinanceRecords();

        foreach ( $data as $record ) {
          if ( $record['finance_type'] == 'income' ) {
            print '
              <tr>
                <th>' . $record['transaction_name'] . '</th>
                <td style="color: #77dd77;">$' . number_format($record['amount'], 2, '.', ',') . '</td>
                <td>' . date('M j', strtotime($record['timestamp'])) . '</td>
                <td><button value="' . $record['id'] . '">D</button></td>
              </tr>
            ';
          } else {
            print '
              <tr>
                <th>' . $record['transaction_name'] . '</th>
                <td style="color: #E96245;">$' . number_format( $record['amount'], 2, '.', ',' ) . ' </td>
                <td>' . date('M j', strtotime($record['timestamp'])) . '</td>
                <td><button value="' . $record['id'] . '"> D</button></td>
              </tr>
            ';
          }
        }
      }

    }

?>