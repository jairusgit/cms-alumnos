<?php if (isset($_SESSION['usuario'])){ ?>
    <nav>
        <ul>
            <li><a href="<?php echo $_SESSION['home'] ?>panel">Inicio</a></li>
            <li><a href="<?php echo $_SESSION['home'] ?>panel/noticias">Noticias</a></li>
            <li><a href="<?php echo $_SESSION['home'] ?>panel/usuarios">Usuarios</a></li>
            <li><a href="<?php echo $_SESSION['home'] ?>panel/salir">Salir</a></li>
        </ul>
    </nav>
<?php } ?>