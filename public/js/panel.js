$(document).ready(function(){

    //Mensajes borrar
    $('.boton_borrar').click(function () {
        var id = $(this).attr('data-id');
        $("#"+id).slideToggle();
    });

    //Cambiar clave
    $("input[type=checkbox][name=cambiar_clave]").click(function () {
        $("input[type=password]").toggleClass( "d-none" );
    });

});