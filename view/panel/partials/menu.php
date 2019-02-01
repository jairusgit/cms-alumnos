<?php if (isset($_SESSION['usuario'])){ ?>
    <nav>
        <ul>
            <li><a href="<?php echo $_SESSION['home'] ?>panel">Inicio</a></li>
            <?php if ($_SESSION['usuario']->noticias == 1){ ?>
                <li><a href="<?php echo $_SESSION['home'] ?>panel/noticias">Noticias</a></li>
            <?php } ?>
            <?php if ($_SESSION['usuario']->usuarios == 1){ ?>
                <li><a href="<?php echo $_SESSION['home'] ?>panel/usuarios">Usuarios</a></li>
            <?php } ?>
            <li><a href="<?php echo $_SESSION['home'] ?>panel/salir">Salir</a></li>
        </ul>
    </nav>
<?php } ?>