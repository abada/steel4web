$(document).ready(function() {



    var table = $('#lotPointer').DataTable({
        responsive: false,
        "scrollX": true,
        "iDisplayLength": 25,
        "language": {
          "emptyTable": "Nenhum Conjunto Disponivel."
        }
    });
 
    $('#formButton').click( function() {
        var data = table.$('input, select').serialize();
         jQuery.ajax({
                type: "POST",
                data: {dados:data},
               url: "http://localhost/new_s4w/saas/estagio/teste",
                dataType: "html",
                success: function(e){
                    $('#herehtml').html(result);
                }
            });
        return false;
    } );

 //  $.fn.editable.defaults.mode = 'inline';

            $('.username').editable({
           url: 'http://localhost/new_s4w/saas/estagio/teste',
           type: 'html',
            mode: 'inline',
           pk: 1,
           title: 'Enter username',
           success: function(result){
           	alert(result);
           	var myArray = result.split('&');
           	for (var i = 0; i < myArray.length; ++i) {
           			
           	
           $('#inputEtapa').append($('<option>', {
			    value: 1,
			    text: myArray[i]
			}));
           };
        }
    });

      $('.dob').editable({
      	 url: 'http://localhost/new_s4w/saas/estagio/teste',
           type: 'html',
           name: 'data',
        format: 'YYYY-MM-DD',    
        viewformat: 'DD.MM.YYYY',    
        template: 'D / MMMM / YYYY',    
        combodate: {
                minYear: 2000,
                maxYear: 2016,
                minuteStep: 1
        },
        success: function(d){
                    $('#herehtml').html(result);
                }
    });

      $('.loadingImp').hide();
      $('.TypeLoading').hide();
      $('.inputObr').removeClass('hidden');

      $('#inputChooseObra').change(function() {
      	$('.TypeLoading').show();

      	var dados = $('#inputChooseObra').val();
     	jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/obras/"+dados+"/etapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputEtapa').find('option').remove().end();
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
        
      });

      $('#inputEtapa').change(function() {
        $('.TypeLoading').show();

        var dados = $('#inputEtapa').val();
        var obra = $('#inputChooseObra').val();
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/obras/"+obra+"/etapas/"+dados+"/subetapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputSubetapa').find('option').remove().end();
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
        
      });

      $('#inputSubetapa').change(function() {
        $('.TypeLoading').show();

        var sub = $('#inputSubetapa').val();
        var etapa = $('#inputEtapa').val();
        var obra = $('#inputChooseObra').val();
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/obras/"+obra+"/etapas/"+etapa+"/subetapas/"+sub+"/lotes",
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
