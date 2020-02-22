<?php

class Report extends Finance{
    private $data = null;

      public function __construct() {
        $this->data = new Finance();
        
      }

      function printReport($userId){
       
        $report=$this->data->getFinanceData($userId); 
   
        if (!empty( $report) ) {
            foreach($report as $record ) {
                echo "<tr><td>" . $record['id']
                . "</td><td>" . $record["transaction_name"] 
                . "</td><td>" . number_format($record['amount'], 2, '.', ',' )
                . "</td><td>" . $record["category"]
                . "</td><td>" . $record["finance_type"]
                . "</td><td>" .  date('F j, Y', strtotime($record['timestamp']))
                . "</td></tr>"; 
            }
            echo "</tbody>";
        }
    }  

    function getEmail($userId){
      $email=$this->data->getEmailData($userId); 
      echo $email['email'];
    }

    function getYears($userId)
    {
      $years=$this->data->getYearsData($userId);
      if (!empty( $years) )
      {
      for($i=0;$i<count($years);$i++) 
      {
       
      $tmp[$i]=date('Y', strtotime($years[$i]['timestamp']));
      }
    }
      return $tmp;
    }
}

