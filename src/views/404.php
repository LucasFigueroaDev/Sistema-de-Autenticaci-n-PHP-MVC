<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página No Encontrada</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <div class="container error-container">
        <div class="login-box">
            <div class="login-form-container">
                <div class="error-code">404</div>
                <div class="error-title">Página No Encontrada</div>
                <div class="error-message">
                    Lo sentimos, la página que buscas no existe o ha sido movida.
                </div>
                <div class="user-actions">
                    <a href="<?php echo BASE_URL; ?>home" class="btn btn-primary">Ir al Inicio</a>
                    <a href="<?php echo BASE_URL; ?>login" class="btn btn-secondary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>