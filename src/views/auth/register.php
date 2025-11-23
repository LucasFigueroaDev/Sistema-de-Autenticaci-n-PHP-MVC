<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Profesional</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <div class="login-title">
                    <h1>Crear Cuenta</h1>
                </div>
                <div class="login-subtitle">
                    Únete a nuestra plataforma
                </div>
            </div>
            <div class="login-form-container">
                <?php if (function_exists('display_modal_message')) display_modal_message(); ?>

                <form id="form" class="login-form" method="POST" action="<?php echo BASE_URL; ?>register">
                    <div class="form-group">
                        <input type="text" class="input" placeholder="Nombre de usuario" name="username" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="input" placeholder="Correo electrónico" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="input" placeholder="Contraseña" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="input" placeholder="Confirmar contraseña" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn-login">Crear Cuenta</button>
                    <p class="message">
                        ¿Ya tienes cuenta? <a href="<?php echo BASE_URL; ?>login">Inicia sesión aquí</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>