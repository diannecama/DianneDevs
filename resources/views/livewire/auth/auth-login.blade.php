<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Style */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: url("background.jpeg") no-repeat center/cover; /* Ensure the path is correct */
        }

        /* Main Container */
        .main {
            width: 270px; /* Set width for card */
            height: 370px;
            padding: 20px;
            background: #ffffff; /* White background for card */
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Softer shadow effect */
        }

        /* Form Styles */
        .login {
            width: 100%;
            text-align: center;
        }

        label {
            font-size: 2em; /* Label font size */
            margin: 20px 0; /* Label margin */
            font-weight: bold;
            display: block; /* Make label block for better spacing */
        }

        /* Input Container with Icon */
        .input-container {
            width: 80%; /* Increased width for inputs */
            height: 30px; /* Increased height for inputs */
            background: rgba(224, 224, 224, 0.9); /* Light grey background for input container */
            display: flex;
            align-items: center;
            margin: 15px auto; /* Adjusted margin */
            padding: 10px;
            border-radius: 5px;
            position: relative;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            color: #6d44b8;
        }

        input {
            width: 100%;
            height: 100%;
            padding: 10px 10px 10px 40px; /* Extra padding for the icon */
            border: none;
            outline: none;
            background: none; /* Removed default background */
            font-family: 'Jost', sans-serif;
            color: #000; /* Input text color set to black */
        }

        /* Button Styles */
        button {
            width: 70%; /* Increased button width */
            height: 45px; /* Increased button height */
            margin: 20px auto; /* Adjusted margin */
            justify-content: center;
            display: block;
            color: #fff;
            background: #6d44b8; /* Button background color */
            font-size: 1.1em; /* Slightly larger font size */
            font-weight: bold;
            border: none;
            border-radius: 5px;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        button:hover {
            background: #8f63d0; /* Lighter color on hover */
        }

        /* Styling for "Don't have an account?" and links */
        p {
            font-size: 0.9em;
            margin-top: 20px;
            text-align: center;
        }

        a {
            color: #6d44b8; /* Link color */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #8f63d0; /* Link hover color */
        }
    </style>
</head>
<body>
    <div class="main">  
        <div class="login">
            <form id="loginForm">
                <label for="login">Login</label>
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pswd" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p><a href="{{ route('register') }}">Don't have an account? Register here.</a></p>
        </div>
    </div>

    <script>
        // Handle login form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Get the input values
            const email = this.email.value;
            const password = this.pswd.value;

            // Retrieve stored credentials
            const storedEmail = localStorage.getItem('userEmail');
            const storedPassword = localStorage.getItem('userPassword');

            if (email === storedEmail && password === storedPassword) {
                // Successful login
                window.location.href = "{{ route('homepage') }}";
            } else {
                alert("Invalid email or password!"); // Alert for invalid credentials
            }
        });
    </script>
</body>
</html>
