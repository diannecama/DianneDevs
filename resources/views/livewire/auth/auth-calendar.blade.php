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

        .calendar-container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .header button:hover {
            background-color: #0056b3;
        }

        .month-year {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .week-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            color: #6c757d;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .day-cell {
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .day-cell.available {
            background-color: #e0ffe0;
        }

        .day-cell.booked {
            background-color: #ffe0e0;
            cursor: not-allowed;
        }

        .day-cell:hover {
            background-color: #cce7ff;
        }

        .day-cell.selected {
            background-color: #007bff;
            color: #fff;
        }

        .side-panel {
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid #ccc;
        }

        .side-panel .book-now {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .side-panel .book-now:hover {
            background-color: #218838;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer button {
            padding: 10px;
            margin: 5px;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .footer button:hover {
            background-color: #5a6268;
        }

        .footer .help-faq {
            background-color: #ffc107;
        }

        .footer .help-faq:hover {
            background-color: #e0a800;
        }

        .footer .view-bookings {
            background-color: #17a2b8;
        }

        .footer .view-bookings:hover {
            background-color: #138496;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .input-field {
            margin: 10px 0;
        }

        .input-field input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        <!-- Content Wrapper -->
        <!-- Calendar Section -->
        <div class="calendar-container">
                    <div class="header">
                        <button class="prev-month">Previous</button>
                        <div class="month-year">
                            <span class="current-month">Month</span>
                            <span class="current-year">Year</span>
                        </div>
                        <button class="next-month">Next</button>
                    </div>

                    <div class="week-days">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>

                    <div class="calendar-grid">
                        <!-- Calendar cells will be dynamically generated -->
                    </div>

                    <div class="side-panel">
                        <div class="selected-date">
                            <span class="date-text">Selected Date:</span>
                            <span class="date-value">None</span>
                        </div>
                        <div class="available-times">
                            <span class="times-text">Available Times:</span>
                            <ul class="time-slots">
                                <!-- Available times will be listed here -->
                            </ul>
                        </div>
                        <button class="book-now" disabled>Book Now</button>
                    </div>

                    <div class="booking-details">
                        <h3>Booking Details</h3>
                        <p id="bookingInfo"></p>
                    </div>
                </div>

                <div class="footer">
                    <button class="view-bookings">View My Bookings</button>
                    <button class="help-faq">Help/FAQ</button>
                </div>

                <!-- Modal for Booking Form -->
                <div id="bookingModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Booking Form</h2>
                        <div class="input-field">
                            <input type="text" id="clientName" placeholder="Your Name" required>
                        </div>
                        <div class="input-field">
                            <input type="email" id="clientEmail" placeholder="Your Email" required>
                        </div>
                        <div class="input-field">
                            <input type="tel" id="clientPhone" placeholder="Your Phone" required>
                        </div>
                        <button id="confirmBooking">Confirm Booking</button>
                    </div>
                </div>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
            <!-- FullCalendar -->
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

            <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthNames = ["January", "February", "March", "April", "May", "June", 
                                "July", "August", "September", "October", "November", "December"];

            const currentMonthElement = document.querySelector('.current-month');
            const currentYearElement = document.querySelector('.current-year');
            const calendarGrid = document.querySelector('.calendar-grid');
            const prevMonthButton = document.querySelector('.prev-month');
            const nextMonthButton = document.querySelector('.next-month');
            const selectedDateElement = document.querySelector('.date-value');
            const timeSlotsList = document.querySelector('.time-slots');
            const bookNowButton = document.querySelector('.book-now');
            const bookingModal = document.getElementById('bookingModal');
            const closeModalButton = document.querySelector('.close');
            const confirmBookingButton = document.getElementById('confirmBooking');
            const bookingInfoElement = document.getElementById('bookingInfo');
            const bookingDetailsSection = document.querySelector('.booking-details');

            // Object to hold available times for specific dates
            const availableTimes = {
                1: ['10:00 AM', '02:00 PM', '04:00 PM'],
                3: ['11:00 AM', '01:00 PM', '03:00 PM'],
                7: ['09:00 AM', '12:00 PM', '03:00 PM'],
                // Add more dates and available times as needed
            };

            let bookedDates = []; // Array to keep track of booked dates
            const currentDate = new Date();

            function renderCalendar() {
                // Update month and year display
                currentMonthElement.textContent = monthNames[currentDate.getMonth()];
                currentYearElement.textContent = currentDate.getFullYear();

                // Clear previous calendar cells
                calendarGrid.innerHTML = '';

                // Determine the first and last days of the month
                const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                const numDays = lastDay.getDate();
                const startingDay = firstDay.getDay();

                // Create empty cells for the calendar
                for (let i = 0; i < startingDay; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.classList.add('day-cell');
                    calendarGrid.appendChild(emptyCell);
                }

                // Create day cells
                for (let day = 1; day <= numDays; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.classList.add('day-cell');

                    const isBooked = bookedDates.includes(day);
                    dayCell.classList.add(isBooked ? 'booked' : 'available');

                    dayCell.textContent = day;
                    dayCell.addEventListener('click', function() {
                        if (isBooked) return;
                        document.querySelectorAll('.day-cell').forEach(cell => cell.classList.remove('selected'));
                        dayCell.classList.add('selected');
                        selectedDateElement.textContent = day;

                        // Show available times for the selected date
                        timeSlotsList.innerHTML = '';
                        if (availableTimes[day]) {
                            availableTimes[day].forEach(time => {
                                const timeSlot = document.createElement('li');
                                timeSlot.textContent = time;
                                timeSlot.addEventListener('click', () => {
                                    bookNowButton.disabled = false;
                                    bookNowButton.setAttribute('data-day', day);
                                    bookNowButton.setAttribute('data-time', time);
                                });
                                timeSlotsList.appendChild(timeSlot);
                            });
                        }

                        // If there are no available times, disable the Book Now button
                        if (timeSlotsList.children.length === 0) {
                            bookNowButton.disabled = true; 
                        }
                    });

                    calendarGrid.appendChild(dayCell);
                }
            }

            // Navigate to previous month
            prevMonthButton.addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            // Navigate to next month
            nextMonthButton.addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            // Show booking modal
            bookNowButton.addEventListener('click', function() {
                if (bookNowButton.disabled) return;
                bookingModal.style.display = 'block';
            });

            // Close modal
            closeModalButton.addEventListener('click', function() {
                bookingModal.style.display = 'none';
            });

            // Confirm booking
            confirmBookingButton.addEventListener('click', function() {
                const name = document.getElementById('clientName').value;
                const email = document.getElementById('clientEmail').value;
                const phone = document.getElementById('clientPhone').value;

                if (name && email && phone) {
                    const bookedDay = bookNowButton.getAttribute('data-day');
                    const bookedTime = bookNowButton.getAttribute('data-time');
                    bookedDates.push(parseInt(bookedDay)); // Mark this day as booked
                    
                    // Display booking details
                    bookingInfoElement.textContent = `Booking Confirmed for ${name} on ${bookedDay} at ${bookedTime}`;
                    bookingDetailsSection.style.display = 'block'; // Show booking details section
                    
                    alert(`Booking Confirmed for ${name} on ${bookedDay} at ${bookedTime}`);
                    bookingModal.style.display = 'none';
                    renderCalendar();
                } else {
                    alert('Please fill in all fields.');
                }
            });

            renderCalendar();
        });

    </script>
</body>
</html>