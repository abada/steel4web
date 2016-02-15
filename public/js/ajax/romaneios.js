$(document).ready(function() {


      $('.loadingImp').hide();
      $('.TypeLoading').hide();
      $('.inputObr').removeClass('hidden');

      $('#inputChooseObra').change(function() {
      $('.inputetapa').addClass('hidden');
      $('.inputsubetapa').addClass('hidden');
      $('.inputimp').addClass('hidden');
      $('.TypeLoading').show();

      

      var dados = $('#inputChooseObra').val();
      if(dados != 0){
     	jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas",
          dataType: "html",
          success: function(result){
            var etapas = JSON.parse(result);
       $('#inputEtapa').find('option').remove().end();
       $('#inputEtapa').append($('<option>', {
          value: 0,
          text: 'Todas'
      }));
       etapas.forEach( function (etapa){                  
             $('#inputEtapa').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
        });
      $('.TypeLoading').hide();
      $('.inputetapa').removeClass('hidden');
      $('#inputSubmit').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }
      });

      $('#inputEtapa').change(function() {
        $('.inputsubetapa').addClass('hidden');
      $('.inputimp').addClass('hidden');
        $('.TypeLoading').show();

        var dados = $('#inputEtapa').val();
        if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputSubetapa').find('option').remove().end();
             $('#inputSubetapa').append($('<option>', {
                value: 0,
                text: 'Todas'
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
      $('.inputimp').addClass('hidden');
        $('.TypeLoading').show();

        var sub = $('#inputSubetapa').val();
      if(sub != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/subetapas/"+sub+"/importacoes",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputImp').find('option').remove().end();
             $('#inputImp').append($('<option>', {
                value: 0,
                text: 'Todas'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputImp').append($('<option>', {
                  value: etapa.id,
                  text: etapa.descricao
              }));
              });
            $('.TypeLoading').hide();
            $('.inputimp').removeClass('hidden');
            
                }
           
            });
    }
       else{
              $('.TypeLoading').hide();
            }
        
      });


  $('#inputSubmit').click(function(e) {
    e.preventDefault();
    $('.TypeLoading').show();
     var oID = $('#inputChooseObra').val();
     var eID = $('#inputEtapa').val();
     var sID = $('#inputSubetapa').val();
     var iID = $('#inputImp').val();
     if (!isset(eID))
        eID = 0;
      if (!isset(sID))
        eID = 0;
        if (!isset(iID))
        eID = 0;

      jQuery.ajax({
        type: "POST",
        data: {eID:eID, sID:sID, iID:iID, oID:oID},
       url: urlbaseGeral+"/romaneios/setRHistory",
        dataType: "html",
        success: function(r){
            window.location.href = r;
        }
      });
  });

 
var table = $('#lotPointer').DataTable({
        responsive: false,
        "scrollX": true,
        "iDisplayLength": 25,
        "language": {
          "emptyTable": "Nenhum Conjunto Disponivel."
        }
    });

 table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

         $('.toBeHidden').hide();

    $('.dragable').sortable({  
    connectWith: '.dragable',  
    handle: '.box-header',  
    cursor: 'move',  
    placeholder: 'placeholder',  
    forcePlaceholderSize: true,  
    opacity: 0.4,  
})  
.disableSelection();  

/* ======================================================== */
/* ============================2=========================== */

$('#inputChooseObra2').change(function() {
  $('.inputimp3').addClass('hidden');
  $('.inputsubetapa3').addClass('hidden');
      $('.TypeLoading').show();

      

      var dados = $('#inputChooseObra2').val();
      $('#inputChooseObra3').val(dados).change();
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas",
          dataType: "html",
          success: function(result){
            var etapas = JSON.parse(result);
       $('#inputEtapa2').find('option').remove().end();
       $('#inputSubetapa2').find('option').remove().end();
       $('#inputEtapa3').find('option').remove().end();
       $('#inputSubetapa2').append($('<option>', {
                value: 0,
          text: 'Escolha uma Etapa...'
            }));
       $('#inputEtapa2').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
       $('#inputEtapa3').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
       etapas.forEach( function (etapa){                  
             $('#inputEtapa2').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
             $('#inputEtapa3').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
        });
      $('.TypeLoading').hide();
      $('.inputetapa2').removeClass('hidden');
      $('.inputetapa3').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }
      });

      $('#inputEtapa2').change(function() {
        $('.inputimp3').addClass('hidden');
        $('.TypeLoading').show();

        var dados = $('#inputEtapa2').val();
        $('#inputEtapa3').val(dados).change();
        if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputSubetapa2').find('option').remove().end();
             $('#inputSubetapa3').find('option').remove().end();
             $('#inputSubetapa2').append($('<option>', {
                value: 0,
                text: 'Escolha uma Subetapa...'
            }));
             $('#inputSubetapa3').append($('<option>', {
                value: 0,
                text: 'Todas'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputSubetapa2').append($('<option>', {
                  value: etapa.id,
                  text: etapa.cod
              }));
                    $('#inputSubetapa3').append($('<option>', {
                  value: etapa.id,
                  text: etapa.cod
              }));
              });
            $('.TypeLoading').hide();
            redrawConjuntos();
            $('.inputsubetapa2').removeClass('hidden');
            $('.inputsubetapa3').removeClass('hidden');
                }
            });
    }else{
        $('.TypeLoading').hide();
      }
        
      });

      $('#inputSubetapa2').change(function() {

        var sub = $('#inputSubetapa2').val();
        $('#inputSubetapa3').val(sub);
        if(sub != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/subetapas/"+sub+"/importacoes",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputImp3').find('option').remove().end();
             $('#inputImp3').append($('<option>', {
                value: 0,
                text: 'Todas'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputImp3').append($('<option>', {
                  value: etapa.id,
                  text: etapa.descricao
              }));
              });
            $('.TypeLoading').hide();
            redrawConjuntos();
            $('.inputimp3').removeClass('hidden');
            
                }
           
            });
    }
       else{
              $('.TypeLoading').hide();
            }
        
        
      });

/* ======================================================== */
/* ============================3=========================== */

  $('#inputChooseObra3').change(function() {
    $('.inputimp3').addClass('hidden');
  $('.inputsubetapa3').addClass('hidden');
      $('.TypeLoading').show();

      

      var dados = $('#inputChooseObra3').val();
      $('#inputChooseObra2').val(dados);
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas",
          dataType: "html",
          success: function(result){
            var etapas = JSON.parse(result);
       $('#inputEtapa3').find('option').remove().end();
       $('#inputSubetapa3').find('option').remove().end();
       $('#inputEtapa2').find('option').remove().end();
       $('#inputSubetapa3').append($('<option>', {
                value: 0,
          text: 'Escolha uma Etapa...'
            }));
       $('#inputEtapa3').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
       $('#inputEtapa2').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
       etapas.forEach( function (etapa){                  
             $('#inputEtapa3').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
             $('#inputEtapa2').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
        });
      $('.TypeLoading').hide();
      $('.inputetapa3').removeClass('hidden');
      $('.inputetapa2').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }
      });

      $('#inputEtapa3').change(function() {
        $('.inputimp3').addClass('hidden');
        $('.TypeLoading').show();

        var dados = $('#inputEtapa3').val();
        $('#inputEtapa2').val(dados);
        if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas",
                dataType: "html",
                success: function(result){
                  getConjuntos();
                  var etapas = JSON.parse(result);
             $('#inputSubetapa3').find('option').remove().end();
             $('#inputSubetapa2').find('option').remove().end();
             $('#inputSubetapa2').append($('<option>', {
                value: 0,
                text: 'Escolha uma Subetapa...'
            }));
             $('#inputSubetapa3').append($('<option>', {
                value: 0,
                text: 'Todas'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputSubetapa3').append($('<option>', {
                  value: etapa.id,
                  text: etapa.cod
              }));
                    $('#inputSubetapa2').append($('<option>', {
                  value: etapa.id,
                  text: etapa.cod
              }));
              });
            $('.TypeLoading').hide();
            redrawConjuntos();
            $('.inputsubetapa3').removeClass('hidden');
            $('.inputsubetapa2').removeClass('hidden');
                }
            });
    }else{
        $('.TypeLoading').hide();
      }
        
      });

      $('#inputSubetapa3').change(function() {
$('.TypeLoading').show();
        var sub = $('#inputSubetapa3').val();
        $('#inputSubetapa2').val(sub).change();
        if(sub != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/subetapas/"+sub+"/importacoes",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputImp3').find('option').remove().end();
             $('#inputImp3').append($('<option>', {
                value: 0,
                text: 'Todas'
            }));
             etapas.forEach( function (etapa){                  
                   $('#inputImp3').append($('<option>', {
                  value: etapa.id,
                  text: etapa.descricao
              }));
              });
            $('.TypeLoading').hide();
            redrawConjuntos();
            $('.inputimp3').removeClass('hidden');
            
                }
           
            });
    }
       else{
              $('.TypeLoading').hide();
            }
        
        
      });

  $('#inputImp3').change(function(){
      redrawConjuntos();
  });

/* ======================================================== */
/* ======================== CONJUNTOS ===================== */

 var ConjuntosGrid = $('#criarRomaneioTable').DataTable({
            ajax: {
              type: 'GET',
              url: getConjuntos()
            },
            scrollX: true,
            responsive: true,
            columns:  [
            { "data": "select-checkbox" },
            { "data": "qtd"},
            { "data": "lote" },
            { "data": "conjunto" },
            { "data": "descricao" },
            { "data": "tratamento" },
            { "data": "total" },
            { "data": "carregado" },
            { "data": "saldo" },
            { "data": "cargo" },
            { "data": "romaneio" }
        ],
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        },
        {
          targets: [1, 4], orderable : false
        }
         ],
            select: {
                style: 'multi',
                selector: 'tr td.select-checkbox'
            },
            "language": {
              "emptyTable": "Nenhum Conjunto Disponivel."
            },
        });

function redrawConjuntos(){
   ConjuntosGrid.ajax.url(getConjuntos()).load();

  
    } 

  $(document).on('click', '#CriarRomaneio', function(event) {
    $('.modalRBody').html('<div class="row"><div class="col-md-6"><dl><dt>Obra</dt><dd>'+$('#inputChooseObra3').find(":selected").text()+'</dd><dt>Etapa</dt><dd>'+$('#inputEtapa3').find(":selected").text()+'</dd><dt>Subetapa</dt><dd>'+$('#inputSubetapa3').find(":selected").text()+'</dd></div><div class="col-md-6"></dl><dl><dt>Codigo</dt><dd>'+$('#RCodigo').val()+'</dd><dt>Data de Saida</dt><dd>'+$('#RSaida').val()+'</dd><dt>Previsão de chegada</dt><dd>'+$('#RPrevisao').val()+'</dd></dl><dl><dt>Transportador</dt><dd>'+$('#TNome').val()+'</dd><dt>'+$('#MNome').val()+'</dt><dd>Motorista</dd></dl></div><h3 class="clearfix text-center info">Deseja Continuar?</h3></div></div><div class="modal-footer"><a href="#" id="RoContinuar" class="pull-left btn-success btn" style="margin-left:30px">Sim</a><a href="#" id="RoCancelar" class="pull-right btn-danger btn" style="margin-right:30px">Não</a></div></div>');
    $('#modalRomaneio').modal('show');
  });   


  $(document).on('click', '#RoCancelar', function(event) {
    event.preventDefault();
    $('#modalRomaneio').modal('hide');
  }); 

  $(document).on('click', '#RoContinuar', function(event) {
    event.preventDefault();
    $.fn.serializeAndEncode = function() {
    return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
    }).join('&');
};
    var selectedItems = ConjuntosGrid.rows('.selected').data();
    var selectedQtd = ConjuntosGrid.$('.selected').find('input');
    var handles_ids = {};
    var obra_id     = $('#inputChooseObra2').val();
    var etapa_id   = $('#inputEtapa2').val();
    var subetapa_id = $('#inputSubetapa2').val();
    var romaneio = $('#RomaneiosForm').serializeAndEncode().replace(/%5B%5D/g, '[]');
    for (var i = 0; i < selectedItems.length; i++) {              
          handles_ids[selectedItems[i].conjunto] = selectedQtd[i].value;
    }; 
    jQuery.ajax({
          type: "POST",
         url: urlbaseGeral+"/romaneios/gravar",
         data: {obraID:obra_id, etapaID:etapa_id, subetapaID:subetapa_id, handles:handles_ids, romaneio:romaneio},
          dataType: "html",
          success: function(result){
            console.log('Gonna peel the Banana');
          }
      });
  }); 



});


function isset(object){
    return (typeof object !=='undefined');
}

function getConjuntos(first){
  var obrs     = $('#inputChooseObra3').val();
  var etaps   = $('#inputEtapa3').val();
  var subetaps = $('#inputSubetapa3').val();
  var imps     = $('#inputImp3').val();

    return (urlbaseGeral + '/romaneios/getConjuntos/'+obrs+'X'+etaps+'X'+subetaps+'X'+imps);
        
}

$(document).on('blur', '.nfInput', function(){
  var flag = true;
  var countTrue = 0;
  var countFalse = 0;
  $('.nfInput').each(function() {
        if ($.trim($(this).val()) == '') {
            flag = false;
            countFalse++;
        }
        else {
          countTrue++; 
        }
    });

    if(flag === true){
      $('#nfInputs').append('<input name="Rnf[]" class="form-control nfInput" type="text">');
    }else{
      if(countFalse > 1){
        console.log($(this).length);
        $(this).last().remove();
      }
      
    }
    

  });

$(document).on('change', '.row-qtd', function(event) {
    var value = $(this).val();
     if(value){
      $(this).addClass('selectedInput');
     }
  });






