<?php
include 'src/views/partials/headers.php';
?>

<body>
    <div class=" container">
        <div class="login-box">
            <div class="login-title">
                <h1>Register</h1>
            </div>
            <div class="login-form-container">
                <form id="form" class="register-form">
                    <input type="email" class="input" placeholder="Email">
                    <input type="password" class="input" placeholder="Password">
                    <input type="password" class="input" placeholder="Confirm Password">
                    <p class="message">Already registered? <a href="<?php echo BASE_URL; ?>login">Login</a></p>
                    <button type="submit" class="btn-login" onclick="actionSubmit('rgn')">Register</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    include 'src/views/partials/footer.php';
    ?>