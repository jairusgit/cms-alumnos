<!-- Si existen mensajes, los muestro y luego los borro para que no vuelvan a salir -->
<?php if (isset($_SESSION["mensaje"])) { ?>
        Mensaje <strong><?php echo $_SESSION["mensaje"]['tipo'] ?></strong>:<br>
        <?php echo $_SESSION["mensaje"]['texto'] ?>
    <!-- Borro mensajes -->
    <?php unset($_SESSION["mensaje"]) ?>
<?php } ?>
