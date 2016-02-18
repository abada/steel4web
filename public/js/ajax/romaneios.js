$(document).ready(function() {

  $('#inputImporter').iCheck({
    checkboxClass: 'icheckbox_flat',
    radioClass: 'iradio_minimal-red',
    increaseArea: '20%' // optional
  });


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
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas?has=importacoes",
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
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas?has=importacoes",
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
  $('.checkSetor').addClass('hidden');
      $('.TypeLoading').show();

      

      var dados = $('#inputChooseObra2').val();
      $('#inputChooseObra3').val(dados).change();
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas?has=importacoes",
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
        $('.checkSetor').addClass('hidden');
        $('.TypeLoading').show();

        var dados = $('#inputEtapa2').val();
        $('#inputEtapa3').val(dados).change();
        if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas?has=importacoes",
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
            $('#checkSetor').iCheck('check');
            redrawConjuntos();
            $('.TypeLoading').hide();
            $('.inputsubetapa2').removeClass('hidden');
            $('.checkSetor').removeClass('hidden');
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
    $('.checkSetor').addClass('hidden');
  $('.inputsubetapa3').addClass('hidden');
      $('.TypeLoading').show();

      

      var dados = $('#inputChooseObra3').val();
      $('#inputChooseObra2').val(dados);
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas?has=importacoes",
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
        $('.checkSetor').addClass('hidden');
        $('.inputimp3').addClass('hidden');
        $('.TypeLoading').show();

        var dados = $('#inputEtapa3').val();
        $('#inputEtapa2').val(dados);
        if(dados != 0){
      jQuery.ajax({
                type: "GET",
               url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas?has=importacoes",
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
            $('#checkSetor').iCheck('check');
            redrawConjuntos();
            $('.TypeLoading').hide();
            $('.checkSetor').removeClass('hidden');
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

  // $('#checkSetor').click(function(event) {
  //   redrawConjuntos();
  // });

  $(document).on('ifChanged', '#inputImporter', function(event) {
    redrawConjuntos();
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
            { "data": "estagio" },
            { "data": "conjunto" },
            { "data": "descricao" },
            { "data": "tratamento" },
            { "data": "total" },
            { "data": "carregado" },
            { "data": "saldo" }
        ],
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        },
        {
          targets: [1, 5], orderable : false
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
    var disable = false;
    var dateSaida = $('#RSaida').val();
    if(dateSaida){
    var dateS = dateSaida.split("-");
    var RSaida = dateS[2]+'/'+dateS[1]+'/'+dateS[0];
    var SaidaStyle = 'color:green';
  }else{
    disable = true;
    var RSaida = '-';
    var SaidaStyle = 'color:red';
  }
    var datePrev = $('#RPrevisao').val();
    if(datePrev){
      var dateP = datePrev.split("-");
      var RPrev = dateP[2]+'/'+dateP[1]+'/'+dateP[0];
      var PrevStyle = 'color:green';
    }else{
      disable = true;
      var RPrev = '-';
      var PrevStyle = 'color:red';
    }
    var obra = $('#inputChooseObra3').find(":selected").text();
    if(obra != 'Escolha uma Obra...'){
      var obraStyle = 'color:green';
    }else{
      disable = true;
      obra = '-';
      var obraStyle = 'color:red';
    }
     var etapa = $('#inputEtapa3').find(":selected").text()
    if(etapa != 'Escolha uma Etapa...'){
      var etapaStyle = 'color:green';
    }else{
      disable = true;
      etapa = '-';
      var etapaStyle = 'color:red';
    }
    var subetapa = $('#inputSubetapa3').find(":selected").text();
    var subetapaStyle = 'color:green';
    if(subetapa == 'Todas' || subetapa == 'Escolha uma Subetapa...' || subetapa == 'Escolha uma Etapa...'){
      subetapa = '-';
      subetapaStyle = 'color:red';
      disable = true;
    }
    var Rcodigo = $('#RCodigo').val();
    if(Rcodigo.length > 0){
      RcodStyle = 'color:green';
    }else{
      disable = true;
      Rcodigo = '-';
      RcodStyle = 'color:red';
    }

    var foneRegex = /^\(\d{2}\) \d{4,5}\-\d{4}?$/;
    var emailRegex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    var compRegex = /^[0-9]*$/;

    var Tname = $('#TNome').val();
    var Tfone = $('#TFone').val();
    var Tcont = $('#TCont').val();
    var Tmail = $('#TMail').val();
    var Tstyle = 'color:green';
    var Tmsg = '';
    var checkTMail = emailRegex.test(Tmail);
    var checkTFone = foneRegex.test(Tfone);

    if(Tname.length < 1 || Tfone.length < 1 || Tcont.length < 1 || Tmail.length < 1){
      Tstyle = 'color:red';
      Tmsg = '&nbsp;&nbsp;* Campos em Branco';
      disable = true;
    }else if(checkTFone == false){
        Tstyle = 'color:red';
        Tmsg = '&nbsp;&nbsp;* Telefone Invalido';
        disable = true;
    }else if(checkTMail == false){
      Tstyle = 'color:red';
      Tmsg = '&nbsp;&nbsp;* E-Mail Invalido';
      disable = true;
    }
    
    if(Tname.length < 1){
      Tname = '-';
    }

    var MNome = $('#MNome').val();
    var MFone = $('#MFone').val();
    var MComp = $('#MComp').val();
    var Mstyle = 'color:green';
    var Mmsg = '';
    var checkMFone = foneRegex.test(MFone);
    var checkComp = compRegex.test(MComp);


    if(MNome.length < 1 || MFone.length < 1 || MComp.length < 1){
      Mstyle = 'color:red';
      Mmsg = '&nbsp;&nbsp;* Campos em Branco';
      disable = true;
    }else if(checkMFone == false){
        Mstyle = 'color:red';
        Mmsg = '&nbsp;&nbsp;* Telefone Invalido';
        disable = true;
    }else if(checkComp == false){
      Mstyle = 'color:red';
      Mmsg = '&nbsp;&nbsp;* Comprimento Invalido';
      disable = true;
    }

     if(MNome.length < 1){
      MNome = '-';
    }

    

    var selectedItems = ConjuntosGrid.rows('.selected').data();
    var selectedQtd = ConjuntosGrid.$('.selected').find('input');
    $('#modalTableBody').find('tr').remove();
    $('#ModalTableWrapper').find('h4').remove();
    $('#modalTabel').addClass('hidden');
    var checkCjt = 0;
    for (var i = 0; i < selectedItems.length; i++) {              
        if(selectedQtd[i].value > 0){
          checkCjt++;
          $('#modalTableBody').append('<tr><td>'+selectedItems[i].conjunto+'</td><td>'+selectedItems[i].lote+'</td><td colspan="2">'+selectedQtd[i].value+'</td></tr>');
        }
    }; 

    if(selectedItems.length > 0 && checkCjt > 0){
      $('#modalTabel').removeClass('hidden');
    } 
    else{
      $('#ModalTableWrapper').append('<h4 style="color:red" class="text-center">Nenhum Conjunto Selecionado!</h4>');
      disable = true;
    }
      

    if(disable == true){
     var dtitle = 'title="Campos Invalidos" data-toggle="tooltip" data-html="true"';
     var DClasses = 'class="tooltipo"';
     disable = 'disabled';}
    else{
     disable = '';
     var dtitle = '';
      var DClasses = '';
    }

    $('.modalRBody').html('<div class="row"><div class="col-md-4"><dl><dt style="'+obraStyle+'">Obra</dt><dd>'+obra+'</dd><dt style="'+etapaStyle+'">Etapa</dt><dd>'+etapa+'</dd><dt style="'+subetapaStyle+'">Subetapa</dt><dd>'+subetapa+'</dd></div><div class="col-md-4"></dl><dl><dt style="'+RcodStyle+'">Codigo</dt><dd>'+Rcodigo+'</dd><dt style="'+SaidaStyle+'">Data de Saida</dt><dd>'+RSaida+'</dd><dt style="'+PrevStyle+'">Previsão de chegada</dt><dd>'+RPrev+'</dd><dt style="color:green">Status</dt><dd>'+$('#RStatus').val()+'</dd></dl></div><div class="col-md-4"><dl><dt style="display:inline-block;'+Tstyle+'">Transportadora</dt><span>'+Tmsg+'</span><dd>'+Tname+'</dd><dt style="display:inline-block;'+Mstyle+'">Motorista</dt><span>'+Mmsg+'</span><dd>'+MNome+'</dd></dl></div></div></div><div class="modal-footer"><h3 class="clearfix text-center info">Deseja Continuar?</h3><a '+disable+' '+dtitle+' href="#" id="RoContinuar" class="pull-left btn-success btn '+DClasses+'" style="margin-left:30px">Sim</a><a href="#" id="RoCancelar" class="pull-right btn-danger btn" style="margin-right:30px">Não</a></div></div>');
    $('#modalRomaneio').modal('show');
  });   


  $(document).on('click', '#RoCancelar', function(event) {
    event.preventDefault();
    $('#modalRomaneio').modal('hide');
  }); 

  $(document).on('click', '#RoContinuar', function(event) {
    if ($(this).is("[disabled]")) {
        return false;
    }
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
          success: function(r){
            redrawConjuntos();
            $('#AjaxMessage').html(r+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>');
            $('#modalRomaneio').modal('hide');
            $('#AjaxMessage').removeClass('hidden');
            $('#AjaxMessage').show();
          }
      });
  }); 

 $(document).on('click', '#slideModalTable', function(event) {
   event.preventDefault();
   $('#modalTableBody').slideToggle('fast');
   $('#slideModalTable i').toggleClass('fa-minus fa-plus');
 });

/* ======================================================== */
/* =====================Autocompletes====================== */

  $("#TNome").autocomplete({

        minLength: 2,
        source: function( request, response ) {
            $.ajax({
                url: urlbaseGeral+"/api/transportadoras",
                dataType: "json",
                data: { searchText: request.term, maxResults: 10 },
                success: function( data ) {

                    response( $.map( data, function( item ) {
                       var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                        if(matcher.test(item.nome)){
                        return {    label: item.nome,
                                    value: item.nome, 
                                    id: item.id, 
                                    fone1: item.fone1,
                                    fone2: item.fone2,
                                    contato1: item.contato1,
                                    contato2: item.contato2,
                                    email: item.email,
                                    observacoes: item.observacoes,
                                    }  
                          } 
                    }));
                }
            });
        },
        select: function (event, ui) {
            $('#TNome').val(ui.item.value);
            $('#TFone').val(ui.item.fone1);
            $('#TFone2').val(ui.item.fone2);
            $('#TCont').val(ui.item.contato1);
            $('#TCont2').val(ui.item.contato2);
            $('#TMail').val(ui.item.email);
            $('#TObs').val(ui.item.observacoes);
            $('#TId').val(ui.item.id);
            return false;
        },
    });


 $("#MNome").autocomplete({
        minLength: 2,
        source: function( request, response ) {
            $.ajax({
                url: urlbaseGeral+"/api/motoristas",
                dataType: "json",
                data: { searchText: request.term, maxResults: 10 },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                      var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
                        if(matcher.test(item.nome)){
                        return {    label: item.nome, 
                                    value: item.nome, 
                                    id: item.id, 
                                    fone1: item.fone1,
                                    fone2: item.fone2,
                                    caminhao: item.caminhao,
                                    comprimento: item.comprimento,
                                    observacoes: item.observacoes,
                                    }   
                          }
                    }));
                }
            });
        },
        select: function (event, ui) {
            $('#MNome').val(ui.item.label);
            $('#MFone').val(ui.item.fone1);
            $('#MFone2').val(ui.item.fone2);
            $('#MCam').val(ui.item.caminhao);
            $('#MComp').val(ui.item.comprimento);
            $('#MObs').val(ui.item.observacoes);
            $('#MId').val(ui.item.id);
            return false;
        },
    });

/* ======================================================== */
/* ======================================================== */

});


function isset(object){
    return (typeof object !=='undefined');
}
  
function getConjuntos(first){
  var obrs     = $('#inputChooseObra3').val();
  var etaps   = $('#inputEtapa3').val();
  var subetaps = $('#inputSubetapa3').val();
  var imps     = $('#inputImp3').val();
  if ($('#checkSetor').is(":checked")) {
    var setor = 1;
  }else{
    var setor = 0;
  }
       return (urlbaseGeral + '/romaneios/getConjuntos/'+obrs+'X'+etaps+'X'+subetaps+'X'+imps+'X'+setor);
        
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
