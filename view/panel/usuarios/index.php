<div class="container-fluid">
    <!--Cabecera e iconos-->
    <div class="row">
        <h3 class="col-9">usuarios</h3>
        <div class="col-3 iconos text-right">
            <a href="<?php echo $_SESSION['home'] ?>panel/usuarios/crear" title="añadir usuario">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <!--Cabecera de listado-->
    <div class="row cabecera_listado no-gutters">
        <div class="col-9">
            USUARIO
        </div>
        <div class="col-3 text-right">
            ACCIONES
        </div>
    </div>
    <!--Recorro los usuarios-->
    <?php while ($usuario = $datos->fetchObject()){ ?>
        <div class="row item_listado no-gutters">
            <div class="col-9">
                <!--Nombre de usuario y enlace a editar-->
                <a href="<?php echo $_SESSION['home'] ?>panel/usuarios/editar/<?php echo $usuario->id ?>" title="editar usuario">
                    <?php echo $usuario->usuario ?>
                </a>
            </div>
            <div class="col-3 text-right">
                <!--editar-->
                <a href="<?php echo $_SESSION['home'] ?>panel/usuarios/editar/<?php echo $usuario->id ?>" title="editar usuario">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <!--activar / desactivar-->
                <?php $clase = ($usuario->activo == 1) ? "verde" : "rojo" ?>
                <?php $icono = ($usuario->activo == 1) ? "up" : "down" ?>
                <a class="<?php echo $clase ?>" href="<?php echo $_SESSION['home'] ?>panel/usuarios/activar/<?php echo $usuario->id ?>" title="activar/desactivar usuario">
                    <i class="far fa-thumbs-<?php echo $icono ?>"></i>
                </a>
                <!--borrar-->
                <a class="boton_borrar" data-id="<?php echo $usuario->id ?>" title="borrar usuario">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>
            <!--mensaje borrar-->
            <div class="col-12 mensaje_borrar" id="<?php echo $usuario->id ?>">
                ¿Seguro que desea borrar al usuario <strong><?php echo $usuario->usuario ?></strong>?<br>
                Esta acción no se puede deshacer.<br>
                <a href="<?php echo $_SESSION['home'] ?>panel/usuarios/borrar/<?php echo $usuario->id ?>" title="borrar usuario">
                    Borrar
                </a>
                <a class="boton_borrar" data-id="<?php echo $usuario->id ?>">Cancelar</a>
            </div>
        </div>
    <?php } ?>

</div>