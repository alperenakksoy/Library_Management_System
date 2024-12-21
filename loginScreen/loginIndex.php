<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="stylesheet"  href="loginStyle.css">

</head>
<body>
  
    <header>
        <div class="header-container">
            <div class="header-right">
                <button class="login-btn">Log in</button>
                <button class="signup-btn">Sign Up</button>
            </div>
        </div>
    </header>
    
<div class="wrapper">
    <form action="">
        <h1>Login</h1>
            <div class="input-box">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" required>
            </div>
            <div class="rememberMe">
                <label><input type="checkbox">Remember me</label>
               <a href="#">Forgot password?</a>
            </div>

            <button type="submit" id="loginBtn">Login</button>

            <div class="register-link">
                <p>Dont you have an account? <a href="registerScreen\registerIndex.html"> Register</a></p>
            </div>
    </form>


</div>

<script src="loginApp.js"></script>
</body>
</html>