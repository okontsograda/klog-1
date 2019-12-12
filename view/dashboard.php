<?php
  // TODO :: Move this to an include (namespace) and include on each page instead of invoking each time

  // Include Financial Processing
  include '../model/models.php';
  include '../controller/user.controller.php';
  include '../controller/finance.controller.php';

  // Instantiation handles for the controllers
  $financeHandle = new Finance();
  $userHandle = new Users();

  // Process user login session
  $sessionDuration = $userHandle->sessionCheck($_SESSION['timeout']);

  // Invoke processing of financial form inputs
  $financeHandle->processFinanceInput();

  // TESTS
 $financeHandle->getFinanceData( $_SESSION['uid']) ;
?>

<html>
  <head>
    <title>Home - Dashboard</title>
    <!-- Navigation Bar Template -->
    <?php require_once'navbar.php'; ?>

    <!-- VIEWPORT FOR MOBILE DEVICES -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CUSTOM CSS STYLESHEET -->
    <link rel="stylesheet" href="../include/css/dashboard.css">

  </head>

<script>

$(document).ready(function(){

  // Process finance input to determine if we need an expense category selection option
  $("#financeType").change(function() {
    if ( $(this).val() == "expense" ) {
      // Show finance category select field and add the required attribute
      $('#financeCategoryDisplay').show();
      $('#financeCategory').removeAttr('disabled');
      $('#financeCategory').attr('required');
    } else {
      // Hide finance category select field
      $('#financeCategoryDisplay').hide();
      $('#financeCategory').attr('disabled', '');
    }
  });

  // Process Logout request
  $("#submitLogout").click(function(e) {
    <?php 
      
    ?>
  });

});

</script>

<body>
  <?php print "Session duration: " . $sessionDuration; ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="col-md-12">
          <div class="msg msg-danger">
            <div class="text-center"><h5><?php print date('Y');?> Expenses</h5></div>
            <hr>
            <div class="text-center">
              <h4>$ 
                <?php 
                  print $financeHandle->getSumYearly('expense', $_SESSION['uid']); 
                ?>
              </h4>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="msg msg-info">
            <div class="text-center"><h5><?php print date('Y');?> Income</h5></div>
            <hr>
            <div class="text-center">
              <h4>$ 
                <?php
                  print $financeHandle->getSumYearly('income', $_SESSION['uid']);
                ?>
              </h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
      <div style="display:flex;width:100%;">
          <form method="post">
              <div style="width:50%;">
                <p>TRANSACTION NAME</p>
                <input type="text" id="transactionName" name="transactionName" required>
              </div>
              <div style="width:40%; margin-left:10%;">
                <p>AMOUNT</p>
                <input type="text" id="amount" name="amount" placeholder="$" required>
              </div>
              <div style="width:35%;">
                <p>TYPE</p>
                <select class="form-control" name="financeType" id="financeType" style="font-size:100%;">
                  <option value="income">Income</option>
                  <option value="expense">Expense</option>
                </select>
              </div>
              <div id="financeCategoryDisplay" style="width:47%;margin-left:6%; display: none;">
                <p>CATEGORY</p>
                <select class="form-control" name="financeCategory" id="financeCategory" style="font-size:100%;" disabled="disabled">
                  <option value="Home Renovations">Renovations</option>
                  <option value="Toll Booth">Toll Booth</option>
                </select>
              </div>
              <button class="btn btn-sm btn-block" type="submit" name="submitFinanceRecord" style="background-color: #77dd77; color: white;">Submit</button>
          </form> 
        </div>
      </div>
    </div>
  </div>

  <!-- FORM INPUT -->

  <!-- Financial Summary Table -->
  <div class="container">
    <table class="table table-bordered table-striped table-hover" style="font-size: 100%;">
      <div class="text-center">
        <h3 style="padding-bottom: 12px; font-size:20px;">November Transactions</h3>
      </div>
      <thead>
        <tr>
          <th>Name</th>
          <th>Amount</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $financeHandle->showMonthylRecords(); ?>
      </tbody>
    </table>
  </div>

</body>

</html>
