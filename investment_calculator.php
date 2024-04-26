<?php include("session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Investment Calculator</title>
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
            <img class="img img-fluid rounded-circle" src="uploads\default_profile.png" width="120">
            <h5><?php echo $username ?></h5>
            <p><?php echo $useremail ?></p>
        </div>
            <div class="sidebar-heading">Management</div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span>
                    Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action"><span
                        data-feather="plus-square"></span> Add Expenses</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><span
                        data-feather="dollar-sign"></span> Manage Expenses</a>
                <a href="expensereport.php" class="list-group-item list-group-item-action"><span
                        data-feather="file-text"></span> Expense Report</a>
                <a href="investment_calculator.php" class="list-group-item list-group-item-action sidebar-active"><span
                        data-feather="calculator"></span> Investment Calculator</a>
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
                <h3 class="try">Investment Calculator</h3>
            </nav>
            <!-- End top navigation bar -->

            <!-- Main content -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="principal">Principal Amount:</label>
                                <input type="number" class="form-control" id="principal" name="principal" required>
                            </div>
                            <div class="form-group">
                                <label for="rate">Rate of Interest:</label>
                                <input type="number" class="form-control" id="rate" name="rate" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="time">Time (in years):</label>
                                <input type="number" class="form-control" id="time" name="time" required>
                            </div>
                            <button type="submit" name="calculate" class="btn btn-primary">Calculate</button>
                        </form>
                        <?php if (isset($investment)): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Investment after <?php echo $time; ?> years: <?php echo $investment; ?>
                            </div>
                        <?php endif; ?>
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