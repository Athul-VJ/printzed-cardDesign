<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-google {
            background-color: #db4437;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-google img {
            margin-right: 8px;
        }
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/40" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            My Website
        </a>
    </nav>

    <div class="container">
        <div class="row login-container">
            <div class="col-md-6 d-none d-md-block">
                <!-- Add any content or image for the first column here -->
                <h1>Welcome!</h1>
                <p>This is a sample text for the first column. You can add any content here.</p>
            </div>
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center">Login</h2>
                    <form method="post" action="../controller/loginAction.php">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="emailid">
                        </div>
                        <div class="form-group">
                            <label for="track">Track id</label>
                            <input type="text" class="form-control" id="track" placeholder="Enter Given Track id" name="trackid">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <div class="text-center mt-3">
                            <a href="#">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Printzed Artwork Solutions. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>
