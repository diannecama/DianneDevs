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
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .row {
            display: flex;
            justify-content: flex-end; /* Align cards to the right */
            flex-wrap: wrap;
            gap: 30px;
        }
        .col-lg-6 {
            flex: auto; /* Change to auto for better centering */
            max-width: 90%; /* Ensure it takes the width needed */
            display: flex;
            justify-content: center;
        }
        .card {
            flex: 1;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-items: center;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            padding: 15px;
            background-color: #6d44b8;
            color: white;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding: 15px;
            flex-grow: 1;
        }
        .card-body p {
            margin: 10px 0;
            font-size: 1em;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
            width: 100%;
        }

        .btn:hover {
            background-color: #6d44b8;
        }

        /* Venue Image Styles */
        .venue-images {
            position: relative;
            overflow: hidden;
            height: 300px; /* Increased height for the image container */
            margin-bottom: 10px; /* Added margin for spacing */
            justify-items: center;
        }
        .venue-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            transition: opacity 0.5s ease;
            opacity: 0;
        }

        .venue-image.active {
            opacity: 1;
        }

        /* Contact List Styling */
        .contact-info ul {
            padding: 0;
            list-style-type: none;
        }

        .contact-info ul li {
            font-size: 1em;
            margin: 10px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-lg-6 {
                flex: 0 0 100%;
            }

            .card-header {
                font-size: 1.1em;
            }
        }
    </style>
</head>
</body>
    <div class="row">
        <!-- Reception Venue Card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt"></i> Reception Venue
                </div>
                <div class="card-body">
                    <!-- Image Section -->
                    <div class="venue-images">
                        <img src="h2o.jpg" alt="Venue Image 1" class="venue-image active">
                        <img src="h2o3.jpg" alt="Venue Image 2" class="venue-image">
                        <img src="h2o2.jpg" alt="Venue Image 3" class="venue-image">
                    </div>
                    <p><strong>Venue Name:</strong> H20 Resort</p>
                    <p><strong>Address:</strong> Brgy. Rizal, Viga, Catanduanes</p>
                    <p><strong>Date:</strong> October 30, 2024</p>
                    <p><strong>Time:</strong> 3:00 PM - 11:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Reception Contacts Card -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-address-book"></i> Reception Contacts
                </div>
                <div class="card-body contact-info">
                    <ul>
                        <li><strong>Event Planner:</strong> Richard Olarte - 09356281234</li>
                        <li><strong>Caterer:</strong> Emerich Fining - 09586732114</li>
                        <li><strong>Photographer:</strong> JJ Photography - 09675438762</li>
                        <li><strong>Florist:</strong> Richard Olarte - 09356281234</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image Slider Logic
        const images = document.querySelectorAll('.venue-image');
        let currentImageIndex = 0;

        function showNextImage() {
            images[currentImageIndex].classList.remove('active');
            currentImageIndex = (currentImageIndex + 1) % images.length;
            images[currentImageIndex].classList.add('active');
        }

        setInterval(showNextImage, 3000); // Change image every 3 seconds

        function viewContactDetails() {
            alert("Showing contact details...");
        }
    </script>

</body>
</html>