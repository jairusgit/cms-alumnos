<div class="container-fluid">
    <!--Cabecera e iconos-->
    <div class="row">
        <h3 class="col-9">noticias</h3>
        <div class="col-3 iconos text-right">
            <a href="<?php echo $_SESSION['home'] ?>panel/noticias/crear" title="añadir noticia">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <!--Cabecera de listado-->
    <div class="row cabecera_listado no-gutters">
        <div class="col-9">
            NOTICIA
        </div>
        <div class="col-3 text-right">
            ACCIONES
        </div>
    </div>
    <!--Recorro las noticias-->
    <?php while ($noticia = $datos->fetchObject()){ ?>
        <div class="row item_listado no-gutters">
            <div class="col-1 imagen_mini">
                <!--Imagen de la noticia (si la hay-->
                <?php if (is_file($_SESSION['img'].$noticia->id.".jpg")){ ?>
                    <img src="<?php echo $_SESSION['public']."img/".$noticia->id.".jpg" ?>">
                <?php } ?>
            </div>
            <div class="col-8">
                <!--Nombre de noticia y enlace a editar-->
                <a href="<?php echo $_SESSION['home'] ?>panel/noticias/editar/<?php echo $noticia->id ?>" title="editar noticia">
                    <?php echo $noticia->titulo ?>
                </a>
            </div>
            <div class="col-3 text-right">
                <!--editar-->
                <a href="<?php echo $_SESSION['home'] ?>panel/noticias/editar/<?php echo $noticia->id ?>" title="editar noticia">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <!--home / no home-->
                <?php $clase = ($noticia->home == 1) ? "verde" : "rojo" ?>
                <a class="<?php echo $clase ?>" href="<?php echo $_SESSION['home'] ?>panel/noticias/home/<?php echo $noticia->id ?>" title="poner o no en la home la noticia">
                    <i class="fas fa-home"></i>
                </a>
                <!--activar / desactivar-->
                <?php $clase = ($noticia->activo == 1) ? "verde" : "rojo" ?>
                <?php $icono = ($noticia->activo == 1) ? "up" : "down" ?>
                <a class="<?php echo $clase ?>" href="<?php echo $_SESSION['home'] ?>panel/noticias/activar/<?php echo $noticia->id ?>" title="activar/desactivar noticia">
                    <i class="far fa-thumbs-<?php echo $icono ?>"></i>
                </a>
                <!--borrar-->
                <a class="boton_borrar" data-id="<?php echo $noticia->id ?>" title="borrar noticia">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>
            <!--mensaje borrar-->
            <div class="col-12 mensaje_borrar" id="<?php echo $noticia->id ?>">
                ¿Seguro que desea borrar la noticiao <strong><?php echo $noticia->titulo ?></strong>?<br>
                Esta acción no se puede deshacer.<br>
                <a href="<?php echo $_SESSION['home'] ?>panel/noticias/borrar/<?php echo $noticia->id ?>" title="borrar noticia">
                    Borrar
                </a>
                <a class="boton_borrar" data-id="<?php echo $noticia->id ?>">Cancelar</a>
            </div>
        </div>
    <?php } ?>

</div>