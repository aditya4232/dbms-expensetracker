<?php include("session.php"); ?>
<?php
    // Define variables and set to empty values
    $initial_investment = $annual_interest_rate = $years = "";
    $future_value = 0;
    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate form inputs
        if (empty($_POST["initial_investment"]) || empty($_POST["annual_interest_rate"]) || empty($_POST["years"])) {
            $error_message = "All fields are required";
        } else {
            // Sanitize and assign form values
            $initial_investment = sanitize_input($_POST["initial_investment"]);
            $annual_interest_rate = sanitize_input($_POST["annual_interest_rate"]);
            $years = sanitize_input($_POST["years"]);

            // Calculate future value
            $future_value = $initial_investment * pow(1 + ($annual_interest_rate / 100), $years);
        }
    }

    function sanitize_input($data) {
        // Remove whitespace, slashes, and convert special characters to HTML entities
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Expense Manager - Investment Calculator</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #BFE1B0;
            color: #0A2F51;
        }

        .container {
            margin-top: 50px;
        }

        .marquee {
            margin-top: 20px;
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(-100%, 0);
            }
        }
    </style>
</head>

<body>
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
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span>
                    Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action"><span
                        data-feather="plus-square"></span> Add Expenses</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
</svg> Manage Expenses</a>
                <a href="expensereport.php" class="list-group-item list-group-item-action"><span
                        data-feather="file-text"></span> Expense Report</a>
                <a href="investment_calculator.php" class="list-group-item list-group-item-action sidebar-active"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator-fill" viewBox="0 0 16 16">
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm2 .5v2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5m0 4v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 12.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM7 9.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM10 6.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5z"/>
</svg>  Investment Calculator</a>
<a href="income.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Income</a>
<a href="budget.php" class="list-group-item list-group-item-action "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
  <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z"/>
</svg> Budget</a>

            </div>
            <div class="sidebar-heading">Settings</div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span>
                    Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action"><span data-feather="log-out"></span>
                    Logout</a>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Page content wrapper -->
        <div id="page-content-wrapper">
            <!-- Top navigation bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="toggler" type="button" id="menu-toggle"><span data-feather="menu"></span></button>
                <div class="col-md-12 text-center">
                <h3 class="try">Investment Calculator</h3>
                </div>
            </nav>
            <!-- End top navigation bar -->

            <!-- Main content -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="initial_investment">Principal Amount:</label>
                                <input type="number" class="form-control" id="initial_investment" name="initial_investment" value="<?php echo $initial_investment; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="annual_interest_rate">Rate of Interest:</label>
                                <input type="number" class="form-control" id="annual_interest_rate" name="annual_interest_rate" step="0.01"value="<?php echo $annual_interest_rate; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="years">Time (in years):</label>
                                <input type="number" class="form-control" id="years" name="years" value="<?php echo $years; ?>" required>
                            </div>
                            <button type="submit" value="calculate" class="btn btn-primary">Calculate</button>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_message)) {
                            echo "<p>Calculation successful. Future value: $" . number_format($future_value, 2) . "</p>";
                        } elseif (!empty($error_message)) {
                            echo "<p style='color: red;'>Error: $error_message</p>";
                        }
                        ?>
                        <br>
                        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
            <!-- End main content -->
        </div>
        <!-- End page content wrapper -->
    </div>
    <!-- End wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <!-- Feather Icons Script -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>