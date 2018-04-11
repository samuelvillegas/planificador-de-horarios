$('.print-button, .imprimir').click(function(){
    window.print();
});

$.extend($.gritter.options, { position: 'top-right' });

$('.file').change(function(){
    var filename = $(this).val();
    filename = filename.split("\\");
    $(this).siblings('input.filename').val(filename[filename.length-1]);
});


$('a[data-modal="subject-detalles"]').click(function(){

    var id = $(this).closest("tr").find(".data-subject").attr("data-subject");
    /*
     consulta de ajax
     */

    //console.log(id);
});


$('a[data-modal="subject-delete"]').click(function(){

    var id = $(this).closest("tr").find(".data-subject").attr("data-subject");
    /*

     */

    $('#delete-subject-button').attr("data-subject", id);

    console.log($('#delete-subject-button').attr("data-subject"));

});

$('#delete-subject-button').click(function(){

    var id = $(this).attr("data-subject");
    $('#tbody-subjects').find('td[data-subject="'+ id +'"]').closest("tr").remove();
});

$(document).ready(function(){
    $.extend($.gritter.options, { position: 'top-left' });


    $('.print-button2').click(function(){
        $($(this).attr("data-print")).printThis({
            importCSS: true,            // import page CSS
            importStyle: true,         // import style tags
            loadCSS: "/assets/lib/bootstrap/dist/css/bootstrap.css",  // path to additional css file - use an array [] for multiple
        });
    });



    /* Data tables */
    /*
     $('#lista-usuarios').DataTable( {
     "processing": true,
     "serverSide": true,
     "ajax": "../server_side/scripts/server_processing.php"
     } );*/

    $(".search").keyup(function () {

        var searchTerm = $(".search").val();
        var listItem = $('.results tbody').children('tr');
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
            return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
        });

        $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','false').hide();
        });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
            $(this).attr('visible','true').show();
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $('.counter').text(jobCount + ' item');

        if(jobCount == '0') {$('.no-result').show();}
        else {$('.no-result').hide();}

        //console.log($(this).val());
    });

});




window.Parsley.addValidator('maxFileSize', {
    validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
            alert('You are making all developpers in the world cringe. Upgrade your browser!');
            return true;
        }
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= maxSize * 1024;
    },
    requirementType: 'integer',
    messages: {
        en: 'This file should not be larger than %s Kb',
        es: 'El archivo no puede ser mayor a %s Kb.'
    }
});

/*-- Validation messages -- */

Parsley.addMessages('es', {
    defaultMessage: "",
    type: {
        email: "Ingrese un correo válido.",
        url: "La url no es válida",
        number: "Sólo se pueden ingresar números",
        integer: "Sólo se pueden ingresar números enteros",
        digits: "Sólo dígitos",
        alphanum: "Este campo es alfanumérico"
    },
    notblank: "No puede estar en blanco",
    required: "Este campo es requerido",
    pattern: "This value seems to be invalid.",
    min: "This value should be greater than or equal to %s.",
    max: "This value should be lower than or equal to %s.",
    range: "This value should be between %s and %s.",
    minlength: "Este valor debe ser de al menos %s caractéres",
    maxlength: "El texto es muy largo. Deber ser de %s caracteres o menos.",
    length: "This value length is invalid. It should be between %s and %s characters long.",
    mincheck: "Debe escoger al menos %s opciones.",
    maxcheck: "You must select %s choices or fewer.",
    check: "You must select between %s and %s choices.",
    equalto: "This value should be the same."
});

Parsley.setLocale('es');

var app = app || {};
// Utils
(function ($, app) {
    'use strict';

    app.utils = {};

    app.utils.formDataSuppoerted = (function () {
        return !!('FormData' in window);
    }());

}(jQuery, app));

// Parsley validators
(function ($, app) {
    'use strict';

    window.Parsley
        .addValidator('filemaxmegabytes', {
            requirementType: 'string',
            validateString: function (value, requirement, parsleyInstance) {

                if (!app.utils.formDataSuppoerted) {
                    return true;
                }

                var file = parsleyInstance.$element[0].files;
                var maxBytes = requirement * 1048576;

                if (file.length == 0) {
                    return true;
                }

                return file.length === 1 && file[0].size <= maxBytes;

            },
            messages: {
                en: 'File is to big',
                es: 'El archivo es muy grande deber ser menor a %s Mb'
            }
        })
        .addValidator('filemimetypes', {
            requirementType: 'string',
            validateString: function (value, requirement, parsleyInstance) {

                if (!app.utils.formDataSuppoerted) {
                    return true;
                }

                var file = parsleyInstance.$element[0].files;

                if (file.length == 0) {
                    return true;
                }

                var allowedMimeTypes = requirement.replace(/\s/g, "").split(',');
                return allowedMimeTypes.indexOf(file[0].type) !== -1;

            },
            messages: {
                en: 'File mime type not allowed',
                es: 'Este tipo de archivo no está permitido'
            }
        }).addValidator("notequalto", {
        requirementType: "string",
        validateString: function(value, element) {
            return value !== $(element).val();
        }
    });
}(jQuery, app));




$('.grado_check').change(function(){

    if($(this).is(':checked')){
        $(this).closest('.be-checkbox').find('.hora_check').attr("required", true);
        //console.log( $(this).closest('.be-checkbox').find('.hora_check'));
    }else{
        $(this).closest('.be-checkbox').find('.hora_check').attr("required", false);
    }

});

/** Ajax - tasks **/
$(document).ready(function () {



    $('#registrar_aula').submit(function (e) {
        e.preventDefault();
        if ($(this).parsley().isValid()) {

            var numero = $('#nombre-aula').val();
            var tipo = $('#tipo-aula').val();
            var capacidad = $('#capacidad-aula').val();

            $('#aula-loading-registrar').show();

            $.ajax({

                type: "POST",

                data: {
                    nombre: numero,
                    capacidad: capacidad,
                    tipo: tipo,
                    registrar_aula: true
                },

                url: "escuela/ajax-aula.php",

                complete: function (data) {
                    $('#aula-loading-registrar').hide();
                },
                success: function (data) {
                    console.log(data);
                    if (data != false) {
                        successMsj('Se ha registrado el aula <b>' + numero + '</b> correctamente');
                    } else {
                        errorMsj('El aula <b>' + numero + '</b> ya existe');
                    }


                },
                error: function (data) {
                    alertify.warning('Ha ocurrido un error');
                }
            });
        }
    });

    $('#usuario').keyup(function (){
        var this_element = $(this);
        var usuario = $(this).val();
        console.log($(this).val());
        $.ajax({

            type: "POST",

            data: {
                usuario: usuario,
                buscar_usuario: true
            },

            url: "escuela/ajax-usuario.php",

            complete: function (data) {

            },
            success: function (data) {
                console.log(data);
                if (data != 0) {
                    this_element.closest('.form-group').addClass('has-error').addClass('has-feedback').removeClass("has-success");
                    $('#hidden_name').val(this_element.val());
                    this_element.attr("data-parsley-notequalto", "#hidden_name");
                    this_element.parsley().addError('forcederror', {message: 'El usuario ya existe.', updateClass: true});
                } else {
                    this_element.closest('.form-group').addClass('has-success').addClass('has-feedback').removeClass("has-error");
                    this_element.parsley().removeError('forcederror');
                    this_element.removeAttr("data-parsley-notequalto");

                }


            },
            error: function (data) {
                alertify.warning('Ha ocurrido un error');
            }
        });
    });

    $('.ver-usuario').on('click',function(){
        var usuario = $(this).attr("data-val");


        $.ajax({

            type: "POST",

            data: {
                usuario: usuario,
                ver_usuario: true
            },

            url: "escuela/ajax-usuario.php",

            complete: function (data) {
                console.log("hi");
            },
            success: function (data) {

                if(data != null){
                    data = JSON.parse(data);
                    console.log(data);
                    var user_header = ' <img src=":imagen:" class="user-avatar"> Usuario: <b>:nombre: :apellido:</b>';
                    user_header = user_header.replace(":imagen:", data.imagen);
                    user_header = user_header.replace(":nombre:", data.nombre);
                    user_header = user_header.replace(":apellido:", data.apellido);

                    var user_details = '<h4>Datos del usuario</h4> ' +
                        '<div class="form-horizontal">' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 text-right">Nombre y apellido:</label> ' +
                        '<div class="col-sm-6"> <p><b>:nombre: :apellido:</b></p> </div> ' +
                        '</div>' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 text-right">Cédula:</label> ' +
                        '<div class="col-sm-6"> <p><b>:cedula:</b></p> </div> ' +
                        '</div>' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 text-right">Perfil:</label> ' +
                        '<div class="col-sm-6"> :perfil: </div> ' +
                        '</div>' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 control-label">Usuario:</label> ' +
                        '<div class="col-sm-6"> <p><b>:usuario:</b></p> </div> ' +
                        '</div>' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 text-right">Teléfono:</label> ' +
                        '<div class="col-sm-6"> <p><b>:telefono:</b></p> </div> ' +
                        '</div>' +
                        '<div class="form-group"> ' +
                        '<label class="col-sm-3 text-right">Dirección:</label> ' +
                        '<div class="col-sm-6"> <p><b>:direccion:</b></p> </div> ' +
                        '</div>' +
                        '</div>';


                    user_details = user_details.replace(":nombre:", data.nombre);
                    user_details = user_details.replace(":apellido:", data.apellido);
                    user_details = user_details.replace(":telefono:", data.telefono);
                    user_details = user_details.replace(":cedula:", data.cedula);
                    user_details = user_details.replace(":direccion:", data.direccion);
                    user_details = user_details.replace(":usuario:", data.usuario);

                    var perfil_str = "";
                    for(var i = 0; i < data.perfiles.length; i++){
                        perfil_str += "<p><b>"+ data.perfiles[i] +"</b></p>";
                    }

                    user_details = user_details.replace(":perfil:", perfil_str);

                    $('#usuario-detalles').find('.modal-body').html(user_details);
                    $('#usuario-detalles').find('.modal-title').html(user_header);
                }else{
                    $('#usuario-detalles').find('.modal-body').html("No se ha encontrado al usuario");
                }
                $("#usuario-detalles").niftyModal("show");

            },
            error: function (data) {
                alertify.warning('Ha ocurrido un error');
            }
        });

    });
    $('.modificar-usuario').on('click',function(){
        var usuario = $(this).attr("data-val");
        console.log(usuario);

        $.ajax({

            type: "POST",

            data: {
                usuario: usuario,
                ver_usuario: true
            },

            url: "escuela/ajax-usuario.php",

            complete: function (data) {
                console.log("hi");
            },
            success: function (data) {

                if(data != null){
                    data = JSON.parse(data);
                    console.log(data);
                    var modificar_form = $('#usuario-modificar').find('form');
                    modificar_form.find('#nombre').val(data.nombre);
                    modificar_form.find('#apellido').val(data.apellido);
                    modificar_form.find('#telefono').val(data.telefono);
                    modificar_form.find('#cedula').val(data.cedula);
                    modificar_form.find('#direccion').val(data.direccion);
                    modificar_form.find('#usuario').val(data.usuario);
                    modificar_form.find('#old_usuario').val(data.usuario);
                    modificar_form.find('#imagen').val(data.imagen);
                    $('#img_usuario').attr("src",  data.imagen);



                    for (var j = 0 ; j < data.perfiles.length; j++){
                        $('#perfil').find('option[data-nombre="'+ data.perfiles[j] +'"]').attr("selected", true);
                        $('select#perfil').select2(); //oh yes just this!
                    }



                }else{
                    $('#usuario-modificar').find('.panel-body').html("No se ha encontrado al usuario");
                }
                $("#usuario-modificar").niftyModal("show");

            },
            error: function (data) {
                alertify.warning('Ha ocurrido un error');
            }
        });

    });
    $('#materia-nombre').change(function(){
        elementoExiste($('#materia-nombre'),"escuela/ajax-materias.php","hidden_materia", "La materia ya existe");
    });

    $('#cedula').change(function(){
        elementoExiste($('#cedula'),"escuela/ajax-usuario.php","hidden_id", "Ya hay un usuario con esa identificación", "buscar_cedula");
    });
});

$('.ver_detalles_materia').click(function () {
    var materia = $(this).attr("data-materia");
    console.log(materia);

    $.ajax({

        type: "POST",

        data: {
            id_materia: materia,
            detalles_materia: true
        },

        url: "escuela/ajax-materias.php",

        complete: function (data) {

        },
        success: function (data) {

            if(data != null){
                console.log(data);
                data = JSON.parse(data);
                console.log(data);
                var modificar_form = $('#subject-detalles');
                modificar_form.find('#tbody-materias-horas').html("");
                modificar_form.find('.materia-nombre').text(data.nombre);
                for(var i = 0; i < data.grados.length; i++){
                    modificar_form.find('#tbody-materias-horas').append(
                        "<tr>"+
                            "<td>"+  data.grados[i].numero + "</td>"+
                            "<td>"+  data.grados[i].hora + "</td>"+
                        "</tr>"
                    );
                }

                modificar_form.find('#tbody-docentes').html("");
                for(var j = 0; j < data.docentes.length ; j++){

                    modificar_form.find('#tbody-docentes').append(
                        "<tr>"+
                            "<td class='user-avatar'><img src='"+ data.docentes[j].imagen +"'>"+  data.docentes[j].docente + "</td>"+
                        "</tr>"
                    );
                }



            }else{
                $('#subject-detalles').find('.panel-body').html("No se ha encontrado la materia");
            }



        },
        error: function (data) {
            errorMsj("No se pudo hacer la busqueda");
        }
    });
});

$('.modificar_detalles_materia').click(function () {
    var materia = $(this).attr("data-materia");
    console.log(materia);

    $.ajax({

        type: "POST",

        data: {
            id_materia: materia,
            detalles_materia: true
        },

        url: "escuela/ajax-materias.php",

        complete: function (data) {

        },
        success: function (data) {

            if(data != null){
                console.log(data);
                data = JSON.parse(data);
                console.log(data);
                var modificar_form = $('#actualizar_materia');
                modificar_form.find("#materia-nombre").val(data.nombre);
                modificar_form.find("#old_name").val(data.nombre);
                modificar_form.find("input[type='checkbox']").attr("checked", false);
                for(var i = 0; i < data.grados.length; i++){
                    var checkbox = modificar_form.find('#'+ data.grados[i].id_grado+"_id");
                    var current_grado = checkbox.val();

                    if(data.grados[i].id_grado == current_grado){
                        checkbox.attr("checked", true);

                        modificar_form.find("input[name='id_hora["+ (parseInt(data.grados[i].id_grado)-1) +"]']").val(data.grados[i].hora);
                    }

                }
                modificar_form.find('#docente_materia').children("option").attr("selected", false);
                for(var j = 0; j < data.docentes.length ; j++){
                    console.log(modificar_form.find('#docente_materia').children("option[value='"+ data.docentes[j].id_persona +"']"));
                    modificar_form.find('#docente_materia').children("option[value='"+ data.docentes[j].id_persona +"']").attr("selected", true);
                }
                $('select#docente_materia').select2();



            }else{
                $('#subject-detalles').find('.panel-body').html("No se ha encontrado la materia");
            }



        },
        error: function (data) {
            errorMsj("No se pudo hacer la busqueda");
        }
    });
});

function elementoExiste(this_element, url, id_hidden_element, mensaje, buscar_value){
    buscar_value = buscar_value || true;
    var elemento = this_element.val();
    $.ajax({

        type: "POST",

        data: {
            elemento: elemento,
            buscar_existe: buscar_value
        },

        url: url,

        complete: function (data) {

        },
        success: function (data) {
            console.log(data);
            if (data != 0) {
                this_element.closest('.form-group').addClass('has-error').addClass('has-feedback').removeClass("has-success");
                $('#'+id_hidden_element).val(this_element.val());
                this_element.attr("data-parsley-notequalto", "#"+id_hidden_element);
                this_element.parsley().addError('forcederror', {message: mensaje, updateClass: true});
            } else {
                this_element.closest('.form-group').addClass('has-success').addClass('has-feedback').removeClass("has-error");
                this_element.parsley().removeError('forcederror');
                this_element.removeAttr("data-parsley-notequalto");

            }


        },
        error: function (data) {
            errorMsj("No se pudo hacer la busqueda");
        }
    });
}


/** Aulas **/

$('.modificar_aula').click(function (){
    var aula_num = $(this).attr("data-aula");

    $.ajax({

        type: "POST",

        data: {
            aula_num: aula_num,
            buscar_aula: true
        },

        url: "escuela/ajax-aula.php",

        complete: function (data) {

        },
        success: function (data) {
            data = JSON.parse(data);

            for(var i=0; i < data.length; i++){
                $('#m_nombre_aula, #m_h_nombre').val(data[i].numero);
                $('#m_capacidad_aula').val(data[i].capacidad);
                $('#m_tipo_aula').find('option[value="'+ data[i].tipo +'"]').attr("selected", true);
            }



        },
        error: function (data) {
            errorMsj("No se pudo hacer la búsqueda");
        }
    });

});

function successMsj(texto, label  ){
    $.extend($.gritter.options, { position: 'top-right' });
    label = label || "Excelente!";
    texto = texto || "";
    $.gritter.add({
        title: label,
        text: texto,
        time: '',
        class_name: 'color success'
    });
}

function errorMsj(texto){
    $.extend($.gritter.options, { position: 'top-right' });
    $.gritter.add({
        title: 'Ha ocurrido un error',
        text: texto,
        time: '',
        class_name: 'color danger'
    });
}

function infoMsj(texto, label){
    $.extend($.gritter.options, { position: 'top-right' });
    label = label || "Información";
    $.gritter.add({
        title: label,
        text: texto,
        time: '',
    });
}

function warningMsj(texto, label){
    $.extend($.gritter.options, { position: 'top-right' });
    label = label || "Alerta!";
    texto = texto || "";
    $.gritter.add({
        title: label,
        text: texto,
        class_name: 'color warning'
    });
}
