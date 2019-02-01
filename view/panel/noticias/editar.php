<div class="container-fluid">
    <!--Cabecera e iconos-->
    <div class="row">
        <h3 class="col-9"><?php echo ($datos->id) ? "editar " : "crear " ?> noticia</h3>
        <div class="col-3 iconos text-right">
            <a href="<?php echo $_SESSION['home'] ?>panel/noticias" title="volver">
                <i class="fas fa-undo-alt"></i>
            </a>
            <a onclick="editar.submit()" title="guardar">
                <i class="far fa-save"></i>
            </a>
        </div>
    </div>
    <?php $id = ($datos->id) ? $datos->id : "nuevo" ?>
    <!--Formulario de subida de datos-->
    <form method="POST" name="editar" action="<?php echo $_SESSION['home'] ?>panel/noticias/editar/<?php echo $id ?>">
        <input type="hidden" name="guardar" value="si">
        <div class="row edicion">
            <div class="col-6">
                <strong>Título:</strong><br>
                <textarea name="titulo" rows="3"><?php echo $datos->titulo ?></textarea><br><br>
                <strong>Autor:</strong><br>
                <input type="text" name="autor" value="<?php echo $datos->autor ?>"><br><br>
                <strong>Slug:</strong><br>
                <?php echo $datos->slug ?><br><br>
            </div>
            <div class="col-6">
                <strong>Entradilla:</strong><br>
                <textarea name="entradilla" rows="3"><?php echo $datos->entradilla ?></textarea><br><br>
                <strong>Fecha:</strong><br>
                <input type="date" name="fecha" value="<?php echo $datos->fecha ?>"><br><br>
            </div>
            <div class="col-12">
                <strong>Texto:</strong><br>
                <textarea name="texto" rows="20"><?php echo $datos->texto ?></textarea><br><br>
            </div>
        </div>
    </form>
    <!--Formulario de subida de imagen-->
    <?php if ($datos->id){ ?>
        <form method="POST" name="subir" action="<?php echo $_SESSION['home'] ?>panel/noticias/subir/<?php echo $id ?>">
            <strong>Imagen:</strong><br>
            <input type="file" name="image">
        </form>
    <?php } ?>

</div>