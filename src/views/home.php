<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Profesional</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>
    <div class="container home-container">
        <div class="home-header">
            <div class="home-title">
                ¡Bienvenido!
            </div>
            <div class="home-subtitle">
                Has iniciado sesión correctamente
            </div>
        </div>
        <div class="home-content">
            <div class="welcome-text">
                Hola, <strong><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Usuario'); ?></strong>
            </div>
            <?php if (function_exists('display_modal_message')) display_modal_message(); ?>
            <div class="user-actions">
                <a href="<?php echo BASE_URL; ?>profile" class="btn btn-primary">Mi Perfil</a>
                <a href="<?php echo BASE_URL; ?>settings" class="btn btn-secondary">Configuración</a>
                <a href="<?php echo BASE_URL; ?>logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</body>

</html>