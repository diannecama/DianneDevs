<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Sriracha&display=swap');

    body {
        margin: 0;
        box-sizing: border-box;
    }

    /* CSS for header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f5f5f5;
    }

    .header .logo {
        font-size: 25px;
        font-family: 'Sriracha', cursive;
        color: #000;
        text-decoration: none;
        margin-left: 30px;
    }

    .nav-items {
        display: flex;
        justify-content: space-around;
        align-items: center;
        background-color: #f5f5f5;
        margin-right: 20px;
    }

    .nav-items a {
        text-decoration: none;
        color: #000;
        padding: 35px 20px;
    }

    /* CSS for main element */
    .intro {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 520px;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.5) 100%), url("{{ asset('background.jpeg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .intro h1 {
        font-family: 'Sriracha', cursive;
        font-size: 60px;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        margin: 0;
    }

    .intro p {
        font-size: 20px;
        color: #d1d1d1;
        text-transform: uppercase;
        margin: 20px 0;
    }

    .intro button {
        background-color: #5edaf0;
        color: #000;
        padding: 10px 25px;
        border: none;
        border-radius: 5px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.4);
    }

    .achievements {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 40px 80px;
    }

    .achievements .work {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0 40px;
    }

    .achievements .work i {
        width: fit-content;
        font-size: 50px;
        color: #333333;
        border-radius: 50%;
        border: 2px solid #333333;
        padding: 12px;
    }

    .achievements .work .work-heading {
        font-size: 20px;
        color: #333333;
        text-transform: uppercase;
        margin: 10px 0;
    }

    .achievements .work .work-text {
        font-size: 15px;
        color: #585858;
        margin: 10px 0;
    }

    .about-me {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 80px;
        border-top: 2px solid #eeeeee;
    }

    .about-me img {
        width: 500px;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .about-me-text h2 {
        font-size: 30px;
        color: #333333;
        text-transform: uppercase;
        margin: 0;
    }

    .about-me-text p {
        font-size: 15px;
        color: #585858;
        margin: 10px 0;
    }

    /* CSS for footer */
    .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #302f49;
        padding: 40px 80px;
    }

    .footer .copy {
        color: #fff;
    }

    .bottom-links {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 40px 0;
    }

    .bottom-links .links {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0 40px;
    }

    .bottom-links .links span {
        font-size: 20px;
        color: #fff;
        text-transform: uppercase;
        margin: 10px 0;
    }

    .bottom-links .links a {
        text-decoration: none;
        color: #a1a1a1;
        padding: 10px 20px;
    }
  </style>
</head>

<body>
    <div> <!-- Single root element -->
        <header class="header">
            <a href="#" class="logo">Wedding Reception Scheduling</a>
            <nav class="nav-items">
                <a href="#home">Home</a>
                <a href="#features">Features</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </nav>
        </header>
  
        <main>
            <div id="home" class="intro">
                <h1>WE MAKE YOUR BIG DAY SPECIAL</h1>
                <p>Schedule Your Wedding Day</p>
                <a href="{{ url('dashboard') }}">
                    <button>Go to Dashboard</button>
                </a>
            </div>
            
            <div id="features" class="achievements">
                <div class="work">
                    <i class="fas fa-calendar-alt"></i>
                    <p class="work-heading">Overview</p>
                    <p class="work-text">"Make your wedding unforgettable with seamless scheduling and stress-free planning."</p>
                </div>
                <div class="work">
                    <i class="fas fa-tools"></i>
                    <p class="work-heading">Skills</p>
                    <p class="work-text">"From coding the perfect interface to understanding the needs of every couple, our skills are dedicated to creating seamless wedding experiences."</p>
                </div>
                <div class="work">
                    <i class="fas fa-thumbs-up"></i>
                    <p class="work-heading">Benefits</p>
                    <p class="work-text">"Experience peace of mind knowing that you have a reliable system to manage your wedding planning, reducing anxiety and helping you enjoy the journey."</p>
                </div>
            </div>

            <div id="about" class="about-me">
                <div class="about-me-text">
                    <h2>About Us</h2>
                    <p>Our mission is to help couples create their dream wedding receptions by offering personalized scheduling solutions tailored to their needs. With a deep understanding of the intricacies involved in wedding planning, we are dedicated to making the process as enjoyable and efficient as possible.</p>
                </div>
                <img src="{{ asset('About Us.jpg') }}" alt="About Us">
            </div>
        </main>
  
        <footer id="contact" class="footer">
            <div class="copy">Contact Us: 09356281234</div>
            <div class="copy">Email: richardolarte@gmail.com</div>
            <div class="bottom-links">
            </div>
        </footer>
    </div> <!-- End of single root element -->
</body>
</html>
