<?php 
include 'src/views/partials/headers.php'; 
?>

<body>
    <div class="container">
        <div class="login-box">
            <div class="login-title">
                <h1>Login</h1>
            </div>
            <div class="login-form-container">
                <form action="<?php echo BASE_URL; ?>login" class="login-form" method="POST">
                    <input type="email" name="email" class="input" placeholder="Email" required>
                    <input type="password" name="password" class="input" placeholder="Password" required>
                    <p class="message">Not registered?</p><a href="<?php echo BASE_URL; ?>register">Register</a>
                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>

<?php 
include 'src/views/partials/footer.php'; 
?>
