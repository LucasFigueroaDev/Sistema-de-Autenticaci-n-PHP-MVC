<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Sistema Profesional</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>

<body>

    <div class="container">
        <div class="login-box">
            <div class="login-header" style="background: var(--primary-color);">
                <div class="login-title">
                    <h1>Mi Perfil</h1>
                </div>
                <p class="login-subtitle">Completa o edita tus datos personales</p>
            </div>

            <div class="login-form-container">
                <form class="login-form" action="<?= BASE_URL ?>profile" method="POST">

                    <div class="form-group">
                        <label for="first_name">Nombre</label>
                        <input type="text" id="first_name" name="first_name" class="input"
                            placeholder="Tu nombre" required
                            value="<?php echo ($user['first_name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Apellido</label>
                        <input type="text" id="last_name" name="last_name" class="input"
                            placeholder="Tu apellido" required
                            value="<?php echo ($user['last_name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="text" id="phone" name="phone" class="input"
                            placeholder="Ej: 11 5264 9823"
                            value="<?php echo ($user['phone'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" id="address" name="address" class="input"
                            placeholder="Calle, altura, ciudad"
                            value="<?php echo ($user['address'] ?? '') ?>">
                    </div>

                    <button type="submit" class="btn-login">Guardar Cambios</button>
                    <a href="<?php BASE_URL ?>home" class="btn btn-primary">Volver</a>
                </form>
                <?php if (function_exists('display_modal_message')) display_modal_message(); ?>
            </div>
        </div>
    </div>

</body>

</html>