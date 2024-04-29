    <?php
    include("session.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reportType = $_POST['report_type'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $query = "";
        $tableHeader = '';
        $periodDates = array();

        switch ($reportType) {
            case 'datewise':
                $query = "SELECT DATE(expensedate) AS period, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY period";
                $tableHeader = 'Date';
                $periodDates = generateDateRange($startDate, $endDate);
                break;
            case 'monthwise':
                $query = "SELECT YEAR(expensedate) AS year, MONTH(expensedate) AS month, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY year, month";
                $tableHeader = 'Year-Month';
                $periodDates = generateMonthYearRange($startDate, $endDate);
                break;
            case 'yearwise':
                $query = "SELECT YEAR(expensedate) AS year, SUM(expense) AS totalExpense FROM expenses WHERE user_id = '$userid' AND expensedate BETWEEN '$startDate' AND '$endDate' GROUP BY year";
                $tableHeader = 'Year';
                $periodDates = generateYearRange($startDate, $endDate);
                break;
        }

        if ($query !== "") {
            $exp_fetched = mysqli_query($con, $query);
        }
    }

    function generateDateRange($startDate, $endDate) {
        $dates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }

    function generateMonthYearRange($startDate, $endDate) {
        $periodDates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $periodDates[] = date('Y-m', $currentDate);
            $currentDate = strtotime('+1 month', $currentDate);
        }

        return $periodDates;
    }

    function generateYearRange($startDate, $endDate) {
        $periodDates = array();
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $periodDates[] = date('Y', $currentDate);
            $currentDate = strtotime('+1 year', $currentDate);
        }

        return $periodDates;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Expense Manager - Expense Report</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            .try {
    font-size: 28px; /* Adjust the font size as needed */
    color: #333;    /* Adjust the color as needed */
    padding: 15px 0px 5px 0px;   /* Adjust the padding as needed */
    }
    .text-center {
        text-align: center;
    }

            </style>
    </head>

    <body>
        <div class="d-flex" id="wrapper">
        <div class="border-right" id="sidebar-wrapper">
        <div class="user">
            <img class="img img-fluid rounded-circle" src="uploads/user.png" width="80">
            <h5><?php echo $username ?></h5>
            <p><?php echo $useremail ?></p>
        </div>
        <div class="sidebar-heading">Management</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action "><span data-feather="home"></span> Dashboard</a>
            <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
            <a href="manage_expense.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
</svg> Manage Expenses</a>
            <a href="expensereport.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="file-text"></span> Expense Report</a>
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
        
            <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


    <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
    <span data-feather="menu"></span>
    </button>
    <div class="col-md-11 text-center">
    <h2 class="try">Expense Report</h2>
    </div>


    </nav>
                <div class="container-fluid">   
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="POST" action="">
                        <div class="form-group row"  style="padding-top: 25px;">
        <label for="report_type" class="col-sm-6 col-form-label"><b>Select Report Type:</b></label>
        <div class="col-md-6">
            <select class="form-control col-sm-12" id="report_type" name="report_type">
                <option value="datewise">Datewise Report</option>
                <option value="monthwise">Monthwise Report</option>
                <option value="yearwise">Yearwise Report</option>
            </select>
        </div>
    </div>


                                <div class="form-group row">
        <label for="start_date" class="col-sm-6 col-form-label"><b>Start Date</b></label>
        <div class="col-md-6">
            <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="start_date" id="start_date" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="end_date" class="col-sm-6 col-form-label"><b>End Date</b></label>
        <div class="col-md-6">
            <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="end_date" id="end_date" required>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Generate Report</button>
        </div>
    </div>

                            </form>

                            <!-- Display the generated report here -->
                            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($exp_fetched)) {
        echo '<h4 class="mt-4">Generated Report</h4>';
        echo '<table class="table table-hover table-bordered">';
        echo '<thead><tr class="text-center">';
        echo '<th>Sl No.</th>';
        echo '<th>' . $tableHeader . '</th>';
        echo '<th>Total Amount</th></tr></thead>';
        echo '<tbody>';

        $count = 1;
        foreach ($periodDates as $periodDate) {
            mysqli_data_seek($exp_fetched, 0); // Reset fetch pointer
            $totalAmount = 0;

            while ($row = mysqli_fetch_array($exp_fetched)) {
                if ($reportType == 'datewise' && $row['period'] == $periodDate) {
                    $totalAmount = $row['totalExpense'];
                    break;
                }
                
                if ($reportType == 'monthwise' && $row['year'] == substr($periodDate, 0, 4) && $row['month'] == substr($periodDate, 5, 2)) {
                    $totalAmount += $row['totalExpense'];
                }
                
                if ($reportType == 'yearwise' && $row['year'] == $periodDate) {
                    $totalAmount += $row['totalExpense'];
                }
            }

            if ($totalAmount > 0) { // Only display if there's expense for this period
                echo '<tr>';
                echo '<td class="text-center">' . $count . '</td>';
                
                if ($reportType == 'datewise') {
                    echo '<td class="text-center">' . $periodDate . '</td>';
                } elseif ($reportType == 'monthwise') {
                    echo '<td class="text-center">' . date('F Y', strtotime($periodDate)) . '</td>';
                } elseif ($reportType == 'yearwise') {
                    echo '<td class="text-center">' . $periodDate . '</td>';
                }
                
                echo '<td  class="text-center">' . $totalAmount . '</td>';
                echo '</tr>';
                $count++;
            }
        }

        echo '</tbody></table>';
    }
    ?>




                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.slim.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/feather.min.js"></script>
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
            $(function () {
                $("#start_date").datepicker();
                $("#end_date").datepicker();
            });
        </script>

    </body>

    </html>