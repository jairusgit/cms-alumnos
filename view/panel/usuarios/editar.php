<div class="container-fluid">
    <!--Cabecera e iconos-->
    <div class="row">
        <h3 class="col-9"><?php echo ($datos->id) ? "editar " : "crear " ?> usuario</h3>
        <div class="col-3 iconos text-right">
            <a href="<?php echo $_SESSION['home'] ?>panel/usuarios" title="volver">
                <i class="fas fa-undo-alt"></i>
            </a>
            <a onclick="editar.submit()" title="guardar">
                <i class="far fa-save"></i>
            </a>
        </div>
    </div>
    <?php $id = ($datos->id) ? $datos->id : "nuevo" ?>
    <form method="POST" name="editar" action="<?php echo $_SESSION['home'] ?>panel/usuarios/editar/<?php echo $id ?>">
        <input type="hidden" name="guardar" value="si">
        <div class="row edicion">
            <div class="col-6">
                <strong>Usuario:</strong><br>
                <input type="text" name="usuario" value="<?php echo $datos->usuario ?>" autocomplete="off"><br><br>
                <strong>Clave:</strong><br>
                <?php $clase = ($datos->id) ? "" : "d-none" ?>
                <span class="<?php echo $clase ?>">
                    <input type="checkbox" name="cambiar_clave"> Pincha para cambiar la clave<br>
                </span>
                <?php $clase2 = ($datos->id) ? "d-none" : "" ?>
                <input type="password" name="clave" autocomplete="off" class="<?php echo $clase2 ?>">

            </div>
            <div class="col-6">
                <strong>Último acceso:</strong><br>
                <?php echo date("d/m/Y H:i", strtotime($datos->fecha_acceso)) ?><br><br>
                <strong>Permisos:</strong><br>
                <label>
                    <input type="checkbox" name="noticias" <?php echo ($datos->noticias == 1) ? "checked" : "" ?>>
                    Noticias
                </label><br>
                <label>
                    <input type="checkbox" name="usuarios" <?php echo ($datos->usuarios == 1) ? "checked" : "" ?>>
                    Usuarios
                </label><br>
            </div>
        </div>
    </form>

</div>