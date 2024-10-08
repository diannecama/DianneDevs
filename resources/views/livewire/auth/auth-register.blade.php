<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
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
        width: 350px;
        height: 500px;
        overflow: hidden;
        background: #fff; /* Gradient with opacity for a smoother look */
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); /* Softer shadow effect */
    }

    /* Form Styles */
    .signup {
        width: 100%;
        height: 100%;
        text-align: center;
        transition: 0.8s ease-in-out;
    }

    label {
        color: #000;
        font-size: 2.3em;
        display: flex;
        justify-content: center;
        margin: 40px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.5s ease-in-out;
    }
    /* Input Container with Icon */
    .input-container {
        width: 70%;
        height: 30px;
        background: rgba(224, 222, 222, 0.9); /* Slightly more transparent background */
        display: flex;
        align-items: center;
        margin: 20px auto;
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
        background: none;
        font-family: 'Jost', sans-serif;
    }
    /* Button Styles */
    button {
        width: 60%;
        height: 40px;
        margin: 10px auto;
        justify-content: center;
        display: block;
        color: #fff;
        background: #573b8a;
        font-size: 1em;
        font-weight: bold;
        margin-top: 20px;
        outline: none;
        border: none;
        border-radius: 5px;
        transition: 0.2s ease-in;
        cursor: pointer;
    }

    button:hover {
        background: #6d44b8;
    }

    /* Styling for links */
    p {
        color: #fff;
        font-size: 0.9em;
        margin-top: 20px;
        text-align: center;
    }
    a {
        color: #6d44b8;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
<body>
    <div class="main">  
        <div class="signup">
            <form id="signupForm">
                <label for="signup">Sign Up</label>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fullname" placeholder="Fullname" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pswd" placeholder="Password" required>
                </div>
                <button type="submit">Sign Up</button>
                <p><a href="{{ route('login') }}">Already have an account? Login here.</a></p>
            </form>
        </div>
    </div>

    <script>
        // Handle the form submission
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get the input values
            const fullname = this.fullname.value;
            const email = this.email.value;
            const password = this.pswd.value;

            // Store the credentials in localStorage for demo purposes
            localStorage.setItem('userEmail', email);
            localStorage.setItem('userPassword', password);

            // Simulate successful registration
            alert('Registration successful! Redirecting to login...');
            // Redirect to login page
            window.location.href = '{{ route("login") }}'; 
        });
    </script>
</body>
</html>