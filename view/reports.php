<?php
  // TODO :: Move this to an include (namespace) and include on each page instead of invoking each time
  session_start();
  include '../model/models.php';
  include '../controller/finance.controller.php';
  include '../controller/report.controller.php';
  

  $reportHandle = new Report();
?>

<html>

<head>
  <title>Reports</title>
  <!-- Navigation Bar Template -->
  <?php require_once'navbar.php'; ?>

  <!-- VIEWPORT FOR MOBILE DEVICES -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CUSTOM CSS STYLESHEET -->
  <link rel="stylesheet" href="../include/css/dashboard.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../include/css/util.css">
  <link rel="stylesheet" type="text/css" href="../include/css/main.css">
  <link href="../include/css/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <script type="text/javascript" src="../include/js/jspdf.debug.js"></script>

</head>
<div class="container">
  <div>
    <button id="print" type="button" class="button" data-toggle="modal" data-target="#btnprint">
      <img src="https://img.icons8.com/office/30/000000/print.png">
    </button>
    <button data-toggle="modal" data-target="#send" id="email" type="button" class="button">
      <img src="https://img.icons8.com/dusk/64/000000/mailbox-closed-flag-down.png">
    </button>

    <button id="pdf" type="submit" name="submit" class="button">
      <img src="https://img.icons8.com/dusk/64/000000/pdf.png">
    </button>

    <button id="excel" type="button" class="button">
      <img src="https://img.icons8.com/dusk/64/000000/ms-excel.png">
    </button>

    <!-- Sort by -->
    <!-- <div class="button"> 
                <button type="button" 
                    class="dropdown-toggle"
                    data-toggle="dropdown"> 
                <img  src="../include/images/filter.png"> <span class="caret"></span> 

                  </button> 
                  
                <ul class="dropdown-menu" role="menu"> 
                    <li class="litext"><a href="#">Transaction name</a></li> 
                    <li class="litext"><a href="#">Amount</a></li> 
                    <li class="litext"><a href="#">Category</a></li> 
                    <li class="litext"><a href="#">Date</a></li> 
                </ul> 
            </div>  -->
  </div>
</div>
<!-- FORM INPUT -->
<!-- Financial Summary Table -->
<div id="customers" class="limiter">
  <div class="container-table100">
    <div class="wrap-table100">
      <div class="table100">
        <table id="report">
          <thead>
            <tr class="table100-head">
              <th class="column1">#</th>
              <th class="column2">Transaction name</th>
              <th class="column3">Amount</th>
              <th class="column4">Category</th>
              <th class="column5">Finance type</th>
              <th class="column6">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $reportHandle->printReport($_SESSION['uid']);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!--print -->
<div id="btnprint" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Select a print period</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="flex-container">

          <div class="fromDate">
            <label for="selectFromMonth">From:</label> </br>
            <select class="form-control" id="selectFromMonth">
              <option value="" selected disabled hidden><?php 
 echo date('F')  ?></option>
              <?php
for($i=1;$i<13;$i++)
print("<option>".date('F',strtotime('01.'.$i.'.2020'))."</option>");
?>
            </select>
          </div>
          <div class="fromYear">
            <label for="selectFromYear"></label> </br></br>
            <select class="form-control" id="selectFromYear">
             
              <?php
      $years= $reportHandle->getYears($_SESSION['uid']);
      $tmp=array_unique($years);
 foreach ($tmp as $value)
 {
   echo("<option>".$value."</option>");
 }
 ?>
            </select>

          </div>
        </div>
        <div class="flex-container">
          <div class="toDate">
            <label for="selectToMonth">To:</label> </br>
            <select class="form-control" id="selectToMonth">
              <option value="" selected disabled hidden><?php 
 echo date('F')  ?></option>
              <?php
for($i=1;$i<13;$i++)
print("<option>".date('F',strtotime('01.'.$i.'.2020'))."</option>");
?>
            </select>
          </div>
          <div class="toMonth">
            <label for="selectToYear"> </label> </br></br>
            <select class="form-control" id="selectToYear">
            
              <?php
foreach ($tmp as $value)
{
  echo("<option>".$value."</option>");
}
 ?>
            </select>
          </div>
        </div>
        <form method="POST"  style="padding-top: 40px">
          <div class="modal-footer" style="padding-bottom: 0px">
            <button name="submit" type="submit" class="btn btn-success" data-dismiss="modal">OK</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<!--send email -->

<!-- Modal -->
<div id="send" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Send e-mail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <form class="mailForm">
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email"
              value="<?php $reportHandle->getEmail($_SESSION['uid']);?>">

            <div class="flex-container">
              <div class="date">
                <label for="selectDay">Select day:</label>
                <select class="form-control day" id="selectDay">
                  <option value="" selected disabled hidden><?php echo date('l')  ?></option>
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option>
                  <option>Sunday</option>
                </select>
              </div>
              <div class="month">
                <label for="selectMonth">Select month:</label> </br>
                <select class="form-control" id="selectMonth">
                  <option value="" selected disabled hidden><?php 
     echo date('F')  ?></option>
                  <?php
for($i=1;$i<13;$i++)
print("<option>".date('F',strtotime('01.'.$i.'.2001'))."</option>");
  ?>
                </select>

              </div>
            </div>
          </div>
        </form>
      </div>
      <form method="POST">
        <div class="modal-footer">
          <button name="submit" type="submit" class="btn btn-success" data-dismiss="modal">Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>
<script type="text/javascript" src="../include/js/datatables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
</script>
<script src="../include/js/index.js"></script>
<script src="../include/js/reports.js"></script>


<script>
  $(document).ready(function () {
    $('#report').DataTable();
    $('.dataTables_length').addClass('bs-select');
  });
</script>

<!-- <script>
     document.getElementById("print").onclick = function() { 
     
      print();
     }
      </script> -->

<script>
  document.getElementById("pdf").onclick = function () {

    convertHTMLtoPDF();

  }
</script>

<script>
  document.getElementById("excel").onclick = function () {
    tableToExcel('report', 'Reports');
  }
</script>

</html>