$(document).ready(function() {



    var table = $('#lotPointer').DataTable({
        responsive: false,
        "scrollX": true,
        "iDisplayLength": 25,
        "language": {
          "emptyTable": "Nenhum Conjunto Disponivel."
        }
    });
 
    $('#pointButton').click( function() {
      $.fn.serializeAndEncode = function() {
    return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
    }).join('&xXx&');
};

        var data = table.$('input, select').serializeAndEncode();
         jQuery.ajax({
                type: "POST",
                data: {dados:data},
               url: urlbaseGeral+"/apontador/apontar",
                dataType: "html",
                success: function(e){
                  var erro = e;
                   $('.TypeLoading').show();
                   var eID = $('#inputEtapa').val();
                   var sID = $('#inputSubetapa').val();
                   var lID = $('#inputLote').val();
                    jQuery.ajax({
                      type: "POST",
                      data: {eID:eID, sID:sID, lID:lID, erro:erro},
                     url: urlbaseGeral+"/apontador/setHistory",
                      dataType: "html",
                      success: function(r){
                          window.location.href = r;
                      }
                    });
                }
            });
        return false;
    } );

 

      $('.loadingImp').hide();
      $('.TypeLoading').hide();
      $('.inputObr').removeClass('hidden');

      $('#inputChooseObra').change(function() {
      	$('.TypeLoading').show();
        $('#inputSubmit').addClass('hidden');
        $('.inputlote').addClass('hidden');
        $('.inputsubetapa').addClass('hidden');

      	var dados = $('#inputChooseObra').val();
        console.log(dados);
        if(dados != 0){

     	jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/obras/"+dados+"/etapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputEtapa').find('option').remove().end();
             $('#inputSubetapa').find('option').remove().end();
             $('#inputLote').find('option').remove().end();
             $('#inputEtapa').append($('<option>', {
                value: 0,
                text: 'Escolha uma Etapa...'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputEtapa').append($('<option>', {
                  value: etapa.id,
                  text: etapa.codigo
              }));
              });
            $('.TypeLoading').hide();
            $('.inputetapa').removeClass('hidden');
                }
            });

        }else{
          $('.TypeLoading').hide();
        }
        
      });

      $('#inputEtapa').change(function() {
        $('.TypeLoading').show();
        $('#inputSubmit').addClass('hidden');
        $('.inputlote').addClass('hidden');

        var dados = $('#inputEtapa').val();
         if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputSubetapa').find('option').remove().end();
             $('#inputLote').find('option').remove().end();
             $('#inputSubetapa').append($('<option>', {
                value: 0,
                text: 'Escolha uma Subetapa...'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputSubetapa').append($('<option>', {
                  value: etapa.id,
                  text: etapa.cod
              }));
              });
            $('.TypeLoading').hide();
            $('.inputsubetapa').removeClass('hidden');
                }
            });

        }else{
            $('.TypeLoading').hide();
        }
        
      });

      $('#inputSubetapa').change(function() {
        $('.TypeLoading').show();

        var sub = $('#inputSubetapa').val();
        if(sub != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/subetapas/"+sub+"/lotes",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputLote').find('option').remove().end();
             $('#inputLote').append($('<option>', {
                value: 0,
                text: 'Todos'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputLote').append($('<option>', {
                  value: etapa.id,
                  text: etapa.descricao
              }));
              });
            $('.TypeLoading').hide();
            $('.inputlote').removeClass('hidden');
            $('#inputSubmit').removeClass('hidden');
                }
            });

      }else{
            $('.TypeLoading').hide();
        }
        
      });

  $('#inputSubmit').click(function(e) {
    e.preventDefault();
    $('.TypeLoading').show();
     var eID = $('#inputEtapa').val();
     var sID = $('#inputSubetapa').val();
     var lID = $('#inputLote').val();
      jQuery.ajax({
        type: "POST",
        data: {eID:eID, sID:sID, lID:lID},
       url: urlbaseGeral+"/apontador/setHistory",
        dataType: "html",
        success: function(r){
            window.location.href = r;
        }
      });
  });

 

         $('#importTable').DataTable({
              responsive: true
          });

         $('.toBeHidden').hide();
    
} );
