<!-- Si existen mensajes, los muestro y luego los borro para que no vuelvan a salir -->
<?php if (isset($_SESSION["mensajes"]) AND count($_SESSION['mensajes']) > 0){ ?>
    <?php foreach ($_SESSION["mensajes"] as $mensaje){ ?>
        Mensaje <strong><?php echo $mensaje['tipo'] ?></strong>:<br>
        <?php echo $mensaje['mensaje'] ?>
    <?php } ?>
    <!-- Borro mensajes -->
    <?php unset($_SESSION["mensajes"]) ?>
<?php } ?>
