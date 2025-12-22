<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    <div class="container">
        
        <?php if(isset($_GET['error'])) { ?>
            <p style="color: red; margin-bottom: 10px;"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        
        <?php if(isset($_GET['success'])) { ?>
            <p style="color: green; margin-bottom: 10px;"><?php echo $_GET['success']; ?></p>
        <?php } ?>


        <div id="login-form">
            <h2>your book space</h2>
            
            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="login-pass" placeholder="Password" required>
                    <i class="fas fa-eye" onclick="togglePassword('login-pass')"></i>
                </div>

                <button type="submit">Log In</button>
            </form>

            <div class="toggle-link">
                No account? <span onclick="showSignup()">Sign Up</span>
            </div>
        </div>


        <div id="signup-form" class="hidden">
            <h2>Create Account</h2>

            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="input-box">
                    <input type="text" name="full_name" placeholder="Full Name" required>
                    <i class="fas fa-user"></i>
                </div>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="signup-pass" placeholder="Password" required>
                    <i class="fas fa-eye" onclick="togglePassword('signup-pass')"></i>
                </div>

                <button type="submit">Sign Up</button>
            </form>

            <div class="toggle-link">
                Have an account? <span onclick="showLogin()">Log In</span>
            </div>
        </div>

    </div>

<script src="login.js"></script>
</body>
</html>