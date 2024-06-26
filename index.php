<?php
  include("session.php");
  $one_month_ago = date("Y-m-d", strtotime("-1 month"));
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_month_ago' GROUP BY expensecategory");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_month_ago' GROUP BY expensecategory");
  
  $one_week_ago = date("Y-m-d", strtotime("-1 week"));
  $exp_date_line = mysqli_query($con, "SELECT DATE_FORMAT(expensedate, '%b %d') AS day_month FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_week_ago' GROUP BY expensedate");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= '$one_week_ago' GROUP BY expensedate");
  
  $yearly_expenses_query = "SELECT YEAR(expensedate) AS year, SUM(expense) AS total_expense
                          FROM expenses
                          WHERE user_id = '$userid'
                          GROUP BY YEAR(expensedate)
                          ORDER BY YEAR(expensedate)";
$yearly_expenses_result = mysqli_query($con, $yearly_expenses_query);
$year_labels = [];
$yearly_expense_data = [];
while ($row = mysqli_fetch_assoc($yearly_expenses_result)) {
    $year_labels[] = $row['year'];
    $yearly_expense_data[] = $row['total_expense'];
}

$monthly_expenses_query = "SELECT DATE_FORMAT(expensedate, '%Y-%m') AS month_year, SUM(expense) AS total_expense
                          FROM expenses
                          WHERE user_id = '$userid'
                          AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                          GROUP BY DATE_FORMAT(expensedate, '%Y-%m')
                          ORDER BY expensedate";
$monthly_expenses_result = mysqli_query($con, $monthly_expenses_query);
$monthly_labels = [];
$monthly_expense_data = [];
while ($row = mysqli_fetch_assoc($monthly_expenses_result)) {
    $monthly_labels[] = $row['month_year'];
    $monthly_expense_data[] = $row['total_expense'];
}

$today_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = CURDATE()");
$yesterday_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
$this_week_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)");
$this_month_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
$this_year_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' AND expensedate >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)");
$total_expense = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid'");

$today_expense_amount = '0' + mysqli_fetch_assoc($today_expense)['SUM(expense)'];
$yesterday_expense_amount ='0' + mysqli_fetch_assoc($yesterday_expense)['SUM(expense)'];
$this_week_expense_amount = '0' + mysqli_fetch_assoc($this_week_expense)['SUM(expense)'];
$this_month_expense_amount = '0' + mysqli_fetch_assoc($this_month_expense)['SUM(expense)'];
$this_year_expense_amount = '0' + mysqli_fetch_assoc($this_year_expense)['SUM(expense)'];
$total_expense_amount = '0' + mysqli_fetch_assoc($total_expense)['SUM(expense)'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Expense Manager - Dashboard</title>
  

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }
    .try {
  font-size: 28px; /* Adjust the font size as needed */
  color: #333;    /* Adjust the color as needed */
  padding: 5px 0px 0px 0px;   /* Adjust the padding as needed */
}
.container {
    padding:0px 20px 20px 20px;/* Add padding to the container */
  }
.card.text-center {
    border: 3px solid #ccc;
    padding: 10px;
    margin: 10px;
    background-color: #E6E6FA;
    border-radius: 5px;
  }

  .card-title {
    font-size: 17.5px;
    margin-bottom: 1px ;
    color: #333;
  }

  .card-text {
    font-size: 24px;
    font-weight: bold;
    color: #6c757d;
  }
  
  </style>

</head>

<body>
  
  
    <style>
    .news-ticker {
      width: 100%;
      background-color: #1D9A6C;
      color: #fff;
      padding: 10px 0;
      overflow: hidden;
    }

    .news-item {
      display: inline-block;
      padding: 0 20px;
      white-space: nowrap;
      animation: marquee 15s linear infinite;
    }

    @keyframes marquee {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
  </style>
</head>

<body>
  

  <div class="news-ticker">
    <div class="news-item">🚀Project aims to track personal finance's and planning of investments :-) </div>
  </div>
</body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="uploads/user.png" width="80">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
</svg> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>
        <a href="investment_calculator.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator-fill" viewBox="0 0 16 16">
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm2 .5v2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5m0 4v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 12.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM7 9.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM10 6.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5z"/>
</svg> Investment Calculator</a>
<a href="income.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Income</a>
<a href="budget.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
  <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z"/>
</svg> Budget</a>


      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>
        <div class="col-md-0 text-center">
          
    <h3 class="try">Dashboard - Homepage</h3>   
    
</div>
        
      </nav>
      <div class="container-fluid">
        <h4 class="mt-4">Full-Expense Report</h4>
        <div class="row">

        <div class="container mt-4">
  <div class="row">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Today's Expense</h5>
          <p class="card-text">₹<?php echo $today_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Yesterday's Expense</h5>
          <p class="card-text">₹<?php echo $yesterday_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Last 7Day's Expense</h5>
          <p class="card-text">₹<?php echo $this_week_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Last 30Day's Expense</h5>
          <p class="card-text">₹<?php echo $this_month_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Current Year Expense</h5>
          <p class="card-text">₹<?php echo $this_year_expense_amount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Expense</h5>
          <p class="card-text">₹<?php echo $total_expense_amount; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>


          <!-- Daily Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Daily Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_line" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Expense Category Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Expense Category</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_category_pie" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Monthly Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Monthly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="monthly_expense_line" height="200"></canvas>
              </div>
            </div>
          </div>
          <!-- Yearly Expenses Chart -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Yearly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_yearly_line" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  <script>
    feather.replace()
  </script>
  <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');

var categories = [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
    echo '"' . $a['expensecategory'] . '",';
} ?>];
var expenses = [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
    echo '"' . $b['SUM(expense)'] . '",';
} ?>];
var colors = [
    '#6f42c1',
    '#dc3545',
    '#28a745',
    '#007bff',
    '#ffc107',
    '#20c997',
    '#17a2b8',
    '#fd7e14',
    '#e83e8c',
    '#6610f2'
];

var dataset = {
    labels: categories,
    datasets: [{
        label: 'Expense by Category (Last Month)',
        data: expenses,
        backgroundColor: colors,
        borderWidth: 1
    }]
};

var options = {
    scales: {
        x: {
            beginAtZero: true,
            ticks: {
                autoSkip: false,
                maxRotation: 45,
                minRotation: 45
            }
        },
        y: {
            beginAtZero: true
        }
    }
};

var myChart = new Chart(ctx, {
    type: 'bar',
    data: dataset,
    options: options
});


var yearlyColors = [
  '#dc3545',  // Red
    '#28a745',  // Green
    '#007bff',  // Blue
    '#ffc107',  // Yellow
    '#20c997',  // Teal
    '#17a2b8',  // Cyan
    '#fd7e14',  // Orange
    '#e83e8c',  // Pink
    '#6610f2'
    ];

    var yearlyLine = document.getElementById('expense_yearly_line').getContext('2d');
    var yearlyChartData = {
      labels: [<?php echo '"' . implode('","', $year_labels) . '"'; ?>],
      datasets: [{
        label: 'Yearly Expense',
        data: [<?php echo implode(',', $yearly_expense_data); ?>],
        borderColor: yearlyColors,
        backgroundColor: yearlyColors,
        fill: false,
        borderWidth: 2
      }]
    };

    var yearlyExpenseChart = new Chart(yearlyLine, {
      type: 'bar',
      data: yearlyChartData,
      options: {
        scales: {
          x: {
            ticks: {
              autoSkip: false,
              maxRotation: 45,
              minRotation: 45
            }
          }
        }
      }
    });

  var monthlyLine = document.getElementById('monthly_expense_line').getContext('2d');
var monthlyChartData = {
    labels: [<?php echo '"' . implode('","', $monthly_labels) . '"'; ?>],
    datasets: [{
        label: 'Monthly Expense (Last Year)',
        data: [<?php echo implode(',', $monthly_expense_data); ?>],
        borderColor: [
            '#fd7e14'
        ],
        backgroundColor: [
            '#fd7e14'
        ],
        fill: false,
        borderWidth: 2
    }]
};
var monthlyExpenseChart = new Chart(monthlyLine, {
    type: 'line',
    data: monthlyChartData,
    options: {
        scales: {
            x: {
                ticks: {
                    autoSkip: false,
                    maxRotation: 45,
                    minRotation: 45
                }
            }
        }
    }
});


var line = document.getElementById('expense_line').getContext('2d');
var myChart = new Chart(line, {
  type: 'line',
  data: {
    labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                echo '"' . $c['day_month'] . '",';
              } ?>],
    datasets: [{
      label: 'Expense by Day (Last Week)',
      data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                echo '"' . $d['SUM(expense)'] . '",';
              } ?>],
      borderColor: [
        '#adb5bd'
      ],
      backgroundColor: [
        '#6f42c1',
        '#dc3545',
        '#28a745',
        '#007bff',
        '#ffc107',
        '#20c997',
        '#17a2b8',
        '#fd7e14',
        '#e83e8c',
        '#6610f2'
      ],
      fill: false,
      borderWidth: 2
    }]
  }
});



    
  </script>
</body>

</html>