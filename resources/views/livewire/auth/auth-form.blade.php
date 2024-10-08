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
        :root {
            --outline: #DADDE8;
            --headings: #47536A;
            --header: #646E8A;
            --font: #A4A9C5;
            --bg: #ECEEF4;
            --hint: #15A4FA;
        }

        body {
            background-color: #E8F0FA;
            font-family: 'Oxygen', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 60rem;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border-radius: 5px;
            max-width: 40rem;
            margin: 20px auto;
            background-color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 27px 24px rgba(0, 0, 0, 0.22), 0 40px 77px rgba(0, 0, 0, 0.22);
        }

        .form__name {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            font-weight: 900;
            background-color: var(--hint);
            padding: 20px;
            color: #fff;
            font-size: 1.2rem;
        }

        .form__section {
            padding: 20px 30px;
        }

        .section {
            color: var(--headings);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .box {
            display: inline-block;
            font-size: 10px;
            font-weight: 900;
            height: 20px;
            width: 20px;
            line-height: 20px;
            border-radius: 50%;
            border: 1px solid var(--headings);
            background-color: var(--headings);
            text-align: center;
            color: #fff;
            margin-right: 10px;
        }

        .form__time, .form__contact {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form__time .date,
        .form__time .time,
        .form__contact .cname,
        .form__contact .cnum {
            flex: 1 1 calc(50% - 20px);
            margin-bottom: 10px;
        }

        .form__time .timezone,
        .form__contact .email,
        .message__container textarea {
            flex: 1 1 100%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--font);
            border-radius: 3px;
            outline: none;
            font-size: 0.9rem;
            font-weight: 700;
            transition: border-color 0.2s ease-in-out;
        }

        button {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            background-color: var(--hint);
            border: 1px solid var(--outline);
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            outline: none;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
            width: calc(100% - 40px);
            margin: 20px auto;
            display: block;
        }

        button:hover {
            background-color: #1293e1;
        }

        button:active {
            background-color: #1083c8;
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
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Form</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('events') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Events</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('venues') }}" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Venues</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('calendar') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i>
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
<body>
    <div class="container">
        <div class="card">
            <div class="form__name">Scheduling Form</div>
            <div class="form__section">
                <div class="section">
                    <div class="box">1</div><span>Date &amp; Time</span>
                </div>
                <form action="" class="form__time">
                    <div class="date">
                        <label for="date">Date</label> 
                        <input id="date" type="date" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="time">
                        <label for="time">Time</label> 
                        <input id="time" type="time">
                    </div>
                    <div class="address">
                        <label for="address">Address</label> 
                        <select name="address" id="address">
                            <option value="-12">Ananong</option>
                            <option value="-11">Mabini</option>
                            <option value="-10">Ogbong</option>
                            <option value="-12">Sta Rosa</option>
                            <option value="-11">San Vicente</option>
                            <option value="-10">Asuncion</option>
                            <!-- More options as needed -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="form__section message__container">
                <div class="section">
                    <div class="box">2</div><span>Your Message</span>
                </div>
                <textarea placeholder="e.g. Please do .. Also, .." rows="5"></textarea>
            </div>
            <div class="form__section">
                <div class="section">
                    <div class="box">3</div><span>Contact Information</span>
                </div>
                <form action="" class="form__contact">
                    <div class="cname">
                        <label for="cname">Client's Name</label> 
                        <input placeholder="e.g. Richard Bovell" id="cname" type="text">
                    </div>
                    <div class="cnum">
                        <label for="cnum">Phone Number</label> 
                        <input id="cnum" type="text">
                    </div>
                    <div class="email">
                        <label for="cemail">Email</label> 
                        <input placeholder="e.g. rb@email.com" id="cemail" type="email">
                    </div>
                </form>
            </div>
            <div class="form__section">
                <button>Send Form</button>
            </div>
        </div>
    </div>
</body>
</html>

