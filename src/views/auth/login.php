<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Profesional</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <div class="login-title">
                    <h1>Bienvenido</h1>
                </div>
                <div class="login-subtitle">
                    Inicia sesión en tu cuenta
                </div>
            </div>
            <div class="login-form-container">
                <?php if (function_exists('display_modal_message')) display_modal_message(); ?>

                <form action="<?php echo BASE_URL; ?>login" class="login-form" method="POST">
                    <div class="form-group">
                        <input type="email" name="email" class="input" placeholder="Correo electrónico" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="input" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn-login">Iniciar Sesión</button>
                    <p class="message">
                        ¿No tienes cuenta? <a href="<?php echo BASE_URL; ?>register">Regístrate aquí</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>