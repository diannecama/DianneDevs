<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" />
    
    <style>
        /* Existing styles */
        body, .sidebar .nav-link, .sidebar .brand-link, .sidebar .nav-link p, .card-title {
            font-family: 'Jost', sans-serif;
        }
        .card-title {
            color: #ffffff;
            text-align: center; 
        }
        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background: #6d44b8;
            color: white;
            padding: 20px; 
            display: flex;
            flex-direction: column;
        }
        .main-sidebar {
            background-color: #6d44b8 !important; 
            color: white !important;
        }
        /* Sidebar Text Color */
        .sidebar .nav-link, .sidebar .brand-link {
            color: #ffffff !important;
        }
        .btn-primary {
            background-color: #6d44b8; 
            border: none; 
            color: white; 
            padding: 10px; 
            border-radius: 5px;
            transition: background-color 0.3s ease; /* Transition effect */
            width: 100%; 
            height: 50px; /* Set height for buttons */
        }
        .btn-primary:hover {
            background-color: #5a37a3; 
        }
        .widget {
            margin-bottom: 1.5rem;
        }
        .card {
            display: flex;
            flex-direction: column; 
            justify-content: space-between; 
            height: 350px; /* Set height for cards */
            width: 100%; /* Use 100% width */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-body {
            flex-grow: 1; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
        }
        .widget ul {
            padding-left: 0;
            list-style: none;
        }
        .widget ul li {
            margin-bottom: 0.5rem;
        }
        .tasks-card {
            border: 2px solid #6d44b8; 
        }
        .tasks-card .card-header {
            background-color: #6d44b8; 
        }
        .recent-activities-card {
            border: 2px solid #6d44b8; 
        }
        .recent-activities-card .card-header {
            background-color: #6d44b8; 
        }
        /* Card hover effect */
        .card:hover {
            transform: translateY(-10px) scale(1.05); /* Move up and slightly enlarge */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4); /* Enhanced shadow on hover */
        }
        /* Card click effect */
        .card:active {
            transform: translateY(-2px) scale(1); /* Slight movement down on click */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Softer shadow on click */
        }
    </style>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
    
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link text-center">
                    <span class="brand-text font-weight-bold">User Dashboard</span>
                </a>
                <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('form') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Form</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('events') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Events</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('venues') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>Venues</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('calendar') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Calendar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Main Content -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center mt-4">
                    <!-- Recent Activities Card -->
                    <div class="col-lg-6 mb-6 d-flex justify-content-center">
                        <div class="card widget recent-activities-card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-history"></i> Recent Activities</h3>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Finalized the venue for the wedding reception on <strong>September 25</strong></li>
                                    <li>Scheduled a cake tasting for  <strong>September 30</strong></li>
                                    <li>Scheduled a photographer for the event</li>
                                </ul>
                                <a href="#my-events" class="btn btn-primary">Add Recent Activities</a>
                            </div>
                        </div>
                    </div>
                    <!-- Upcoming Tasks Card -->
                    <div class="col-lg-6 mb-6 d-flex justify-content-center">
                        <div class="card widget tasks-card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-tasks"></i> Upcoming Tasks</h3>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Confirm wedding reception</li>
                                    <li>Send invites to guests</li>
                                    <li>Confirm floral arrangements</li>
                                    <li>Confirm photographer</li>
                                    <li>Arrange transportation for guests</li>
                                </ul>
                                <a href="#my-events" class="btn btn-primary">Add New Tasks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    </div>
</body>
</html>