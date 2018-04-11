/**
 * Created by Personal on 9/10/2017.
 */
var body_constructor = $('#body-constructor');
var horario_tmp = {};
horario_tmp['rutina'] = [];
var indice_horario = 0;
var disponibilidad = 1;
var modificar = false;
$.extend($.gritter.options, { position: 'top-right' });
$(document).ready(function(){



  var select_grado  = $('#grado-construir');
  var select_seccion  = $('#seccion-construir');
  var select_materia  = $('#materia-construir');
  var select_docente  = $('#docente-construir');
  var select_dia = $('#dia-construir');
  var select_aula  = $('#aula-construir');
  var select_hora_inicio = $("#hora-inicio-construir");
  var select_hora_fin = $("#hora-fin-construir");


  $('#crear_seccion').submit(function (e) {
    e.preventDefault();
    if ($(this).parsley().isValid()) {

      var grado = $('#crear-seccion-grado').val();
      var nombre = $('#crear-seccion-nombre').val();

      $('#aula-loading-registrar').show();
      $.ajax({

        type: "POST",

        data: {
          nombre: nombre,
          grado: grado,
          registrar_seccion: true
        },

        url: "escuela/ajax-grados.php",

        complete: function (data) {
          $('#aula-loading-registrar').hide();
        },
        success: function (data) {
          console.log(data);
          if (data != false) {
            if(data == 2){
              warningMsj("","La sección ya existe");

            }else{
              successMsj("Se ha agregado la nueva sección");
            }

            buscarSeccion(select_grado.val());
          } else {
            errorMsj("No se ha podido guardar la sección");
          }


        },
        error: function (data) {
          errorMsj("No se ha podido guardar la sección");
        }
      });
    }
  });

  $(document).on("click", ".delete-line", function(){

    var data_horario = $(this).closest("tr").attr("data-horario");
    //console.log(data_horario);

    $(this).closest("tr").remove();
    eliminarRutina(data_horario);
    eliminarTabla(data_horario);
  });


  $('#grado-construir').change(function(){
    if($(this).val() != 0){
      buscarMaterias($(this).val());
      buscarSeccion($(this).val());

      horario_tmp['grado'] =  $(this).val();
    }else{
      $('#settings-section').find("select").attr("disabled", true).val(0);
    }
  });


  $('#materia-construir').change(function(){
    var materia = $(this).val();
    if($(this).val() == 999){
      select_aula.attr("disabled", true);
      select_docente.attr("disabled",true);
      select_dia.attr("disabled", true);
      $(this).removeAttr("disabled");
    }else{
      if(materia != 0){
        buscarMateriaDocentes(materia);
      }
      $('#settings-section').find("select").removeAttr("disabled");
    }
  });


  $('#seccion-construir').change(function(){

    if($(this).val() != 0){
      $('#settings-section').find("select").attr("disabled", false).val(0);
      select_seccion.attr("disabled", true);
      select_grado.attr("disabled", true);
      $('#seccion-button').attr("disabled", true);
      infoMsj("Se han bloqueado los campos de grado y sección. <br/> Para cambiarlos recargue la página. Pero se perderán los datos sin guardar");
      horario_tmp['seccion'] =  $(this).val();
      horario_tmp['seccion_numero'] =  $(this).find('option:selected').text();
    }else{
      $('#settings-section').find("select").attr("disabled", true).val(0);
    }

  });

  $('#add-routine').click(function(){


    //var grado = $.trim(select_grado.children("option").filter(":selected").text());
    var val_grado = select_grado.val();


    var seccion = $.trim(select_seccion.children("option").filter(":selected").text());
    var val_seccion = select_seccion.val();


    var materia =$.trim( select_materia.find("option").filter(":selected").text());
    var materia_horas = $.trim( select_materia.find("option").filter(":selected").attr("data-horas"));
    //console.log(materia_horas);
    var val_materia = select_materia.val();


    var docente = select_docente.children("option").filter(":selected").text();
    var val_docente = select_docente.val();

    var val_dia = select_dia.val();

    var hora_inicio = select_hora_inicio.children("option").filter(":selected").text();
    var val_hora_inicio = select_hora_inicio.val();

    var hora_fin = select_hora_fin.children("option").filter(":selected").text();
    var val_hora_fin = select_hora_fin.val();


    var aula =$.trim( select_aula.find("option").filter(":selected").text());

    var val_aula = select_aula.val();

    var random_color = "";


    var error = validarHorario();

    if( val_materia == 999 && (val_hora_inicio > 0) && (val_hora_fin > 0) ){

      var data_horario = "receso_"+val_materia+val_hora_fin+val_hora_inicio;


      var error_rutina = agregarRutina(val_materia, "", val_aula, val_hora_inicio, val_hora_fin, 1, "transparent", data_horario);

      if(error_rutina != true){
        agregarReceso(val_hora_inicio, val_hora_fin, data_horario);
        /*$('#general-view-table').append(
            '<tr class="text-center" data-horario="'+ data_horario +'" data-materia="'+ val_materia +'">' +
            '<td colspan="3"><b>Receso '+ hora_inicio +' - '+ hora_fin +
            '</b></td><td class="actions"><span class="mdi mdi-delete delete-line text-danger" '+
            ' style="cursor: pointer;font-size: 20px;"></span></td>' +
            '</tr>'
        );*/
      }

    }else{
      if( (val_docente > 0) && (val_materia > 0) && (val_seccion > 0) && (error == 0) ){
        random_color = getRandomColor();
        var tiny_random_color = tinycolor(random_color);
        if(tiny_random_color.isDark() ){
            var text_color = "color: #ffffff";
        }else{
            var text_color = "";
        }
        data_horario = val_materia + "_" +    val_grado;

        var error_rutina = agregarRutina(val_materia, val_docente, val_aula, val_hora_inicio, val_hora_fin, val_dia, random_color, data_horario);



        if(error_rutina != true){
            var general_view = $('#general-view-table');
            var general_view_materia = general_view.find("tr[data-materia='"+ val_materia +"']");

          if( general_view_materia.length <= 0){
              general_view.append(
                  '<tr class="text-center" data-horario="'+ data_horario +'" data-materia="'+ val_materia +'">' +
                  '<td style="background-color: '+ random_color +'; '+ text_color +'" data-color="true">'+ seccion +'</td><td data-docente="true">'+ docente + '</td>'+
                  '<td data-materia-td="'+ val_materia +'" >'+ materia +'</td>'+
                  '<td class="actions"><span class="mdi mdi-delete delete-line text-danger" style="cursor: pointer;font-size: 20px;"></span></td>' +
                  '</tr>'
              );
          }else{
            var current_teacher = general_view.find("tr[data-materia='"+ val_materia +"']").find("td[data-docente='true']").text()
            if(  current_teacher != docente){
                general_view.find("tr[data-materia='"+ val_materia +"']").find("td[data-docente='true']").append(", " + docente);
            }
            //general_view.find("tr[data-materia='"+ val_materia +"']").find("td[data-docente='true']").append(", " + docente);
            random_color =  general_view.find("tr[data-materia='"+ val_materia +"']").find("td[data-color='true']").css("backgroundColor");
            horario_tmp.rutina[1].color = random_color;
          }

          agregarTabla(val_hora_inicio, val_hora_fin, random_color, materia, val_dia, aula, data_horario);
        }else{

        }


      }
    }

    //ajax

    //if success



  });



  function validarHorario(){
    var error = 0;

    if( select_materia.val() == null || select_materia.val() == 0 ){

      alertify.error('No se ha seleccionado una materia');
      error = 1

    }



    if(  select_materia.val() != 999){
      if( select_dia.val() == null || select_dia.val() == 0 ){

        alertify.error('No se ha seleccionado un día de la semana');
        error = 1;
      }

      if( select_docente.val() == null || select_docente.val() == 0 ){

        alertify.error('No se ha selccionado un docente');
        error = 1;
      }

      if( select_aula.val() == null || select_aula.val() == 0 ){

        alertify.error('No se ha seleccionado un aula');
        error = 1

      }

    }


    if( select_hora_inicio.val() == null || select_hora_inicio.val() == 0 ){

      alertify.error('No se ha seleccionado una hora de entrada');
      error = 1;
    }

    if(select_hora_fin.val() == null || select_hora_fin.val() == 0 ){

      alertify.error('No se ha seleccionado una hora de salida');
      error = 1;

    }


    if( parseInt(select_hora_fin.val()) <= parseInt(select_hora_inicio.val()) ){

      alertify.error('La hora de salida debe ser después de la hora de entrada');
      error = 1;
    }

    return error;
  }

});

function buscarMateriaDocentes(materia){
  $.ajax({

    type: "POST",

    data: {
      materia: materia,
      buscar_docentes: true
    },

    url: "escuela/ajax-materias.php",

    complete: function (data) {

    },
    success: function (data) {
      if (data != 0) {
        data = JSON.parse(data);
        $('#docente-construir').attr("disabled", false).html(
            '<option value="0">--</option>');

        for (var i = 0; i < data.length; i++) {
          $('#docente-construir').attr("disabled", false).append(
              '<option value="'+ data[i].id +'">'+ data[i].nombre +'</option>');
        }


      } else {


      }


    },
    error: function (data) {
      warningMsj('Ha ocurrido un error');
    }
  });
}

function buscarSeccion(grado){

  $.ajax({

    type: "POST",

    data: {
      grado: grado,
      buscar_seccion: true
    },

    url: "escuela/ajax-grados.php",

    complete: function (data) {

    },
    success: function (data) {
    console.log(data);
      if (data != "[]") {
        data = JSON.parse(data);
          console.log(data);

        $('#seccion-construir').attr("disabled", false).html(
            '<option value="0">--</option>');

        for (var i = 0; i < data.length; i++) {
          $('#seccion-construir').attr("disabled", false).append(
              '<option value="'+ data[i].id +'">'+ data[i].seccion +'</option>');
        }

        $('#seccion-button').attr("disabled", false);

      } else {

        infoMsj("Todas las secciones de este grado ya tienen horario. Si quiere modificar una sección de este grado vaya a horarios > ver lista y seleccione el horario a modificar ", "No hay secciones disponibles");
      }


    },
    error: function (data) {
      warningMsj('Ha ocurrido un error');
    }
  });
}

function buscarMaterias(grado){
  $.ajax({

    type: "POST",

    data: {
      grado: grado,
      buscar_materias: true
    },

    url: "escuela/ajax-grados.php",

    complete: function (data) {

    },
    success: function (data) {
      if (data != 0) {
        data = JSON.parse(data);
        var select_grado_inner = $('#materia-construir').find('#group');

        select_grado_inner.html("");

        for (var i = 0; i < data.length; i++) {
          select_grado_inner.append(
              '<option value="'+ data[i].id +'" data-horas="'+ data[i].horas +'">'+ data[i].materia +'</option>');
        }


      } else {


      }


    },
    error: function (data) {
      warningMsj('Ha ocurrido un error');
    }
  });
}

$('#guardar_horario').click(function(){

  if(horario_tmp['rutina'].length > 0){
    guardarHorario("Listo");
  }else{
    errorMsj("No se han hecho rutina en el horario");
  }

});

$('#guardar_horario_2').click(function(){

    if(horario_tmp['rutina'].length > 0){
        actualizarHorario("Incompleto");
    }else{
        errorMsj("No se han hecho contenido en el horario");
    }

});

$('#actualizar_horario').click(function () {
    if(horario_tmp['rutina'].length > 0){
        actualizarHorario("Listo");
    }else{
        errorMsj("No se han hecho contenido en el horario");
    }

});

$('#actualizar_horario_2').click(function () {
    if(horario_tmp['rutina'].length > 0){
        actualizarHorario("Incompleto");
    }else{
        errorMsj("No se han hecho contenido en el horario");
    }

});
function actualizarHorario(estado) {

    var horario_json = JSON.stringify(horario_tmp);
    console.log(horario_json);

    $.ajax({

        type: "POST",

        data: {
          id_horario:horario_tmp.id,
            horario_json: horario_json,
            estado: estado,
            actualizar_horario: true,
        },

        url: "escuela/ajax-horarios.php",

        complete: function (data) {

        },
        success: function (data) {
            console.log(data);

            if(data == 1){
                successMsj("Se ha actualizado el horario");

            }else{
                if(data == 2){
                    warningMsj("", "Se ha actualizado como borrador");


                }else{
                    errorMsj("Ha ocurrido un error :c");

                }
            }

        },
        error: function (data) {
            warningMsj('Ha ocurrido un error');
        }
    });
}

function guardarHorario(estado){


  var horario_json = JSON.stringify(horario_tmp);
  console.log(horario_json);

  $.ajax({

    type: "POST",

    data: {
      horario_json: horario_json,
        estado: estado,
      guardar_horario: true,
    },

    url: "escuela/ajax-horarios.php",

    complete: function (data) {

    },
    success: function (data) {
      console.log(data);

      if(data == 1){

          window.location.href = 'horarios-vista.php?grado='+ horario_tmp['grado'] +'&seccion='+ horario_tmp['seccion_numero'];
      }else{
          if(data == 2){

              window.location.href = 'horarios-vista.php?grado='+ horario_tmp['grado'] +'&seccion='+ horario_tmp['seccion_numero'];

          }else{
              errorMsj("Ha ocurrido un error :c");

          }
      }

    },
    error: function (data) {
      warningMsj('Ha ocurrido un error');
    }
  });
}

function agregarTabla(hora_inicio, hora_fin, random_color, materia, dia, aula, data_horario){
var td;
    var tiny_random_color = tinycolor(random_color);
    if(tiny_random_color.isDark() ){
        var text_color = "color: #ffffff";
    }else{
        var text_color = "";
    }

  for (var i = hora_inicio; i <= hora_fin-1; i++) {
    td =  body_constructor.find("tr[data-hora-inicio='"+ i +"']")
        .find("td[data-dia='"+ dia +"']");
    if( td.is('[disabled=disabled]') ){

    }else{

      td.attr("disbled", true)
          .css("background-color", random_color)
          .css("color", text_color)
          .html("<b>"+ materia +"</b><br><span>"+ aula +"</span>").attr("data-horario", data_horario);
    }

  }


}

function eliminarTabla(data_horario){
  body_constructor.find("td[data-horario='"+ data_horario +"']").css("background-color", "inherit").children().remove();
}

function agregarReceso(hora_inicio, hora_fin, data_horario){

  for(var j = 1; j <= 5; j++){
    for (var i = hora_inicio; i <= hora_fin-1; i++) {

      $('#body-constructor').find("tr[data-hora-inicio='"+ i +"']")
          .find("td[data-dia='"+ j +"']")
          .html("<b> Receso </b>").attr("data-horario", data_horario);
    }
  }



}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * letters.length)];
    }
    return color;
}

function buscarDisponibilidadDocenteAula(docente, aula, hora_inicio, hora_fin, dia, id_disp_rutina) {
  id_disp_rutina = id_disp_rutina || 0;

    $.ajax({

        type: "POST",

        data: {
            docente: docente,
            aula: aula,
            hora_inicio: hora_inicio,
            hora_fin: hora_fin,
            dia: dia,
            buscar_disponibilidad: true,
            modificar:modificar,
            rutina: id_disp_rutina
        },
        async:false,

        url: "escuela/ajax-horarios.php",

        complete: function (data) {

        },
        success: function (data) {
          var docente_tmp = 1;
          var aula_tmp = 1;


            data = JSON.parse(data);


            if(data['disp_docente'] == 0){
                disponibilidad = 0;
                docente_tmp = 0;
                warningMsj("El docente no está disponible en ese horario");
            }else{
                docente_tmp = 1;
            }

            if(data['disp_aula'] == 0){
                disponibilidad = 0;
                aula_tmp = 0;
                warningMsj("El aula no está disponilbe en ese horario");
            }else{
                aula_tmp = 1;
            }

            if(docente_tmp == 1 && aula_tmp == 1){
              disponibilidad = 1;
            }

        },
        error: function (data) {
            warningMsj('Ha ocurrido un error');
        }
    });


}

function agregarRutina(materia, docente, aula, hora_inicio, hora_fin, dia, color, data_horario){

  if(horario_tmp['rutina'].length <= 0){
      buscarDisponibilidadDocenteAula(docente, aula, hora_inicio, hora_fin, dia);

      if(parseInt(disponibilidad) === 0){

          return true;
      }
  }

  for (var i = 0; i < horario_tmp['rutina'].length; i++) {
console.log(horario_tmp['rutina'][i]);
      if("modificar" in horario_tmp['rutina'][i]){
          buscarDisponibilidadDocenteAula(docente, aula, hora_inicio, hora_fin, dia, horario_tmp['rutina'][i]['id_rutina']);

      }else{
          buscarDisponibilidadDocenteAula(docente, aula, hora_inicio, hora_fin, dia);

      }

    if(parseInt(disponibilidad) === 0){
      return true;
    }
      if( "modificar" in horario_tmp['rutina'][i] ){

        if(horario_tmp['rutina'][i]['modificar'] != 2){

            if(materia == 999){
                for (var j = 0; j < 6; j++) {
                    //console.log(hora_inicio + " " + i);
                    if (( between_inicio(parseInt(hora_inicio), parseInt(horario_tmp['rutina'][i]['hora_inicio']),
                            parseInt(horario_tmp['rutina'][i]['hora_fin'])) ||
                        between_fin(parseInt(hora_fin), parseInt(horario_tmp['rutina'][i]['hora_inicio']),
                            parseInt(horario_tmp['rutina'][i]['hora_fin'])) )
                        && horario_tmp['rutina'][i]['dia'] == j) {
                        errorMsj("El receso choca con otras materias", "No se pudo agregar");
                        return true;
                    }


                }
            }else{
                if(
                    ( between_inicio(parseInt(hora_inicio), parseInt(horario_tmp['rutina'][i]['hora_inicio']), parseInt(horario_tmp['rutina'][i]['hora_fin'])) ||
                    between_fin(parseInt(hora_fin), parseInt(horario_tmp['rutina'][i]['hora_inicio']), parseInt(horario_tmp['rutina'][i]['hora_fin'])) )
                    && horario_tmp['rutina'][i]['dia'] == dia){

                    errorMsj("la materia choca con otra ya registrada", "No se pudo agregar");
                    return true;
                }
            }
        }

      }else{
          if(materia == 999){
              for (var j = 0; j < 6; j++) {
                  //console.log(hora_inicio + " " + i);
                  if (( between_inicio(parseInt(hora_inicio), parseInt(horario_tmp['rutina'][i]['hora_inicio']),
                          parseInt(horario_tmp['rutina'][i]['hora_fin'])) ||
                      between_fin(parseInt(hora_fin), parseInt(horario_tmp['rutina'][i]['hora_inicio']),
                          parseInt(horario_tmp['rutina'][i]['hora_fin'])) )
                      && horario_tmp['rutina'][i]['dia'] == j) {
                      errorMsj("El receso choca con otras materias", "No se pudo agregar");
                      return true;
                  }


              }
          }else{
              if(
                  ( between_inicio(parseInt(hora_inicio), parseInt(horario_tmp['rutina'][i]['hora_inicio']), parseInt(horario_tmp['rutina'][i]['hora_fin'])) ||
                  between_fin(parseInt(hora_fin), parseInt(horario_tmp['rutina'][i]['hora_inicio']), parseInt(horario_tmp['rutina'][i]['hora_fin'])) )
                  && horario_tmp['rutina'][i]['dia'] == dia){

                  errorMsj("la materia choca con otra ya registrada", "No se pudo agregar");
                  return true;
              }
          }
      }



    //console.log(hora_fin +"=="+ horario_tmp['rutina'][i]['hora_inicio'] +"=="+ horario_tmp['rutina'][i]['hora_fin']);
  }

  if(materia == 999){
    for (var i = 0; i < 6; i++) {
      var rutina_tmp = {};
      rutina_tmp['materia'] = materia;
      rutina_tmp['docente'] = docente;
      rutina_tmp['aula'] = aula;
      rutina_tmp['hora_inicio'] = hora_inicio;
      rutina_tmp['hora_fin'] = hora_fin;
      rutina_tmp['dia'] = i;
      rutina_tmp['color'] = color;
      rutina_tmp['data'] = data_horario;

      horario_tmp['rutina'].push(rutina_tmp);
    }
  }else{
    var rutina_tmp = {};
    rutina_tmp['materia'] = materia;
    rutina_tmp['docente'] = docente;
    rutina_tmp['aula'] = aula;
    rutina_tmp['hora_inicio'] = hora_inicio;
    rutina_tmp['hora_fin'] = hora_fin;
    rutina_tmp['dia'] = dia;
    rutina_tmp['color'] = color;
    rutina_tmp['data'] = data_horario;

    horario_tmp['rutina'].push(rutina_tmp);
  }

  indice_horario++;
  console.log(horario_tmp);
  return false;
}

function eliminarRutina(data_horario){
  var i =0;
  while(i < horario_tmp['rutina'].length){
      if (typeof horario_tmp['rutina'][i]['data'] !== 'undefined') {

          if(horario_tmp['rutina'][i]['data'] == data_horario){


              if("modificar" in horario_tmp['rutina'][i]){
                  horario_tmp['rutina'][i]['modificar'] = 2;
              }else{
                  horario_tmp['rutina'].splice(i, 1);
                  i = i - 1;
              }


          }



      }
      i++;
  }



}

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function construirHorario(grado, seccion){

  $.ajax({

    type: "POST",

    data: {
      grado: grado,
      seccion: seccion,
      cargar_horario: true
    },

    url: "escuela/ajax-horarios.php",

    complete: function (data) {
    },
    success: function (data) {
      horario_tmp = JSON.parse(data);
      console.log(horario_tmp);
      modificar = true;
      for(var i = 0; i < horario_tmp['rutina'].length ; i++){

          var general_view = $('#general-view-table');
          var general_view_materia = general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] + "']");

          if( general_view_materia.length <= 0){
              general_view.append(
                  '<tr class="text-center" data-materia="'+ horario_tmp['rutina'][i]['materia_nombre'] + '">' +
                  '<td style="background-color: '+ horario_tmp['rutina'][i]['color'] +' " data-color="true">'
                  + horario_tmp['rutina'][i]['seccion_nombre'] +'</td>'+
                  '<td data-docente="true">' + horario_tmp['rutina'][i]['docente'] +' </td>'+
                  '<td data-materia-td="'+ horario_tmp['rutina'][i]['materia_nombre'] + '" >'+ horario_tmp['rutina'][i]['materia_nombre'] + '</td>'+
                  '</tr>'
              );
          }else{
              var current_teacher = general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] +"']").find("td[data-docente='true']").text()

              if(  current_teacher.trim() != horario_tmp['rutina'][i]['docente'].trim() ){
                  //console.log(current_teacher +" " + docente);
                  general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] +"']").find("td[data-docente='true']").append(", "+ horario_tmp['rutina'][i]['docente'] );
              }

          }


        for(var j = parseInt(horario_tmp['rutina'][i]['hora_inicio']) ; j <= parseInt(horario_tmp['rutina'][i]['hora_fin']); j++){

              var tiny_random_color = tinycolor(horario_tmp['rutina'][i]['color']);
            if(tiny_random_color.isDark() ){
                var text_color = "color: #ffffff";
            }else{
                var text_color = "";
            }
          $('tr[data-hora-inicio="'+ j +'"]')
              .find('td[data-dia="'+ horario_tmp['rutina'][i]['dia'] +'"]')
              .css('background-color', horario_tmp['rutina'][i]['color'])
              .css('color', text_color)
              .html('<b>'+ horario_tmp['rutina'][i]['materia_nombre'] +'</b><br><span>'+ horario_tmp['rutina'][i]['aula_numero'] +'</span>');


        }

      }

    },
    error: function (data) {
      warningMsj('Ha ocurrido un error');
    }
  });

}

function construirHorarioModificar(grado, seccion){

    $.ajax({

        type: "POST",

        data: {
            grado: grado,
            seccion: seccion,
            cargar_horario: true
        },

        url: "escuela/ajax-horarios.php",

        complete: function (data) {
        },
        success: function (data) {
            horario_tmp = JSON.parse(data);
            console.log(horario_tmp);

            for(var i = 0; i < horario_tmp['rutina'].length ; i++){


                var general_view = $('#general-view-table');
                var general_view_materia = general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] + "']");

                if( general_view_materia.length <= 0){
                    general_view.append(
                        '<tr class="text-center"  data-horario="'+ horario_tmp['rutina'][i]['data'] +'" data-materia="'+ horario_tmp['rutina'][i]['materia_nombre'] + '">' +
                        '<td style="background-color: '+ horario_tmp['rutina'][i]['color'] +' " data-color="true">'
                        + horario_tmp['rutina'][i]['seccion_nombre'] +'</td>'+
                        '<td data-docente="true">' + horario_tmp['rutina'][i]['docente'] +' </td>'+
                        '<td data-materia-td="'+ horario_tmp['rutina'][i]['materia_nombre'] + '" >'+ horario_tmp['rutina'][i]['materia_nombre'] + '</td>'+
                        '<td class="actions"><span class="mdi mdi-delete delete-line text-danger" style="cursor: pointer;font-size: 20px;"></span></td>' +
                        '</tr>'
                    );
                }else{
                    var current_teacher = general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] +"']").find("td[data-docente='true']").text()

                    if(  current_teacher.trim() != horario_tmp['rutina'][i]['docente'].trim() ){
                        //console.log(current_teacher +" " + docente);
                        general_view.find("tr[data-materia='"+ horario_tmp['rutina'][i]['materia_nombre'] +"']").find("td[data-docente='true']").append(", "+ horario_tmp['rutina'][i]['docente'] );
                    }

                }


                for(var j = parseInt(horario_tmp['rutina'][i]['hora_inicio']) ; j <= parseInt(horario_tmp['rutina'][i]['hora_fin']); j++){

                    var tiny_random_color = tinycolor(horario_tmp['rutina'][i]['color']);
                    if(tiny_random_color.isDark() ){
                        var text_color = "color: #ffffff";
                    }else{
                        var text_color = "";
                    }

                    $('tr[data-hora-inicio="'+ j +'"]')
                        .find('td[data-dia="'+ horario_tmp['rutina'][i]['dia'] +'"]')
                        .css('background-color', horario_tmp['rutina'][i]['color'])
                        .css('color', text_color)
                        .html('<b>'+ horario_tmp['rutina'][i]['materia_nombre'] +'</b><br><span>'+ horario_tmp['rutina'][i]['aula_numero'] +'</span>')
                        .attr("data-horario", horario_tmp['rutina'][i]['data']);


                }

            }

        },
        error: function (data) {
            warningMsj('Ha ocurrido un error');
        }
    });

}

function between_inicio(x, min, max) {
  return x >= min && x < max;
}

function between_fin(x, min, max) {
  return x > min && x <= max;
}