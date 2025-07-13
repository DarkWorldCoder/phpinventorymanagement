<?php require_once 'php_action/core.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharma Vault</title>
    <link rel="icon" href="logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="custom/css/custom.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">
    <!-- File Input -->
    <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
    
    <!-- jQuery -->
    <script src="assests/jquery/jquery.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
    <script src="assests/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assests/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">
                    <img src="logo.png" alt="Pharma Vault" style="height: 30px; display: inline-block; margin-right: 8px;">
                    <span style="font-weight: 600; color: var(--primary-600);">Pharma Vault</span>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li id="navDashboard">
                        <a href="dashboard.php">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <li id="navBrand">
                        <a href="brand.php">
                            <i class="fa fa-tags"></i> Brands
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <li id="navCategories">
                        <a href="categories.php">
                            <i class="fa fa-th-list"></i> Categories
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <li id="navProduct">
                        <a href="product.php">
                            <i class="fa fa-cube"></i> Products
                        </a>
                    </li>
                    <?php } ?>
                    
                    <li class="dropdown" id="navOrder">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-shopping-cart"></i> Orders <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li id="topNavAddOrder">
                                <a href="orders.php?o=add">
                                    <i class="fa fa-plus"></i> Add Orders
                                </a>
                            </li>
                            <li id="topNavManageOrder">
                                <a href="orders.php?o=manord">
                                    <i class="fa fa-edit"></i> Manage Orders
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <li id="navReport">
                        <a href="report.php">
                            <i class="fa fa-bar-chart"></i> Reports
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <li id="importbrand">
                        <a href="importbrand.php">
                            <i class="fa fa-upload"></i> Import Brand
                        </a>
                    </li>
                    <?php } ?>
                    
                    <li class="dropdown" id="navSetting">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle"></i> Account <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                            <li id="topNavSetting">
                                <a href="setting.php">
                                    <i class="fa fa-cog"></i> Settings
                                </a>
                            </li>
                            <li id="topNavUser">
                                <a href="user.php">
                                    <i class="fa fa-user-plus"></i> Add User
                                </a>
                            </li>
                            <li class="divider"></li>
                            <?php } ?>
                            <li id="topNavLogout">
                                <a href="logout.php">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="dashboard-container" style="margin-top: 70px;">
        <div class="container-fluid">