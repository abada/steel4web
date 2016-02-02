$(document).ready(function() {
//var livePath = 'steel4web.com.br/s4w_1/public';
var livePath = '';

$('#noSortObra').DataTable({
        responsive: true,
        "ordering": false,
        "bInfo" : false
    });


var toBe2 = 0;
$('.toBeHidden').hide();
$('#subToggle').click(function(e) {
   if(toBe2%2 == 0){
    $('.toBeHidden').show();
    $('.clickTable').removeClass('fa-plus').addClass('fa-minus');
  }else{
    $('.toBeHidden').hide();
    $('.clickTable').removeClass('fa-minus').addClass('fa-plus');
  }
  toBe2++;
});
  
  $(document).on('click', '.clickTable', function(){ 
    var id = event.target.id;
      $('.'+id).toggle();
      $(this).toggleClass('fa-minus fa-plus');
  });


    var table = $('#lotPointer').DataTable();
 
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
               url: livePath+"/api/obras/"+dados+"/etapas",
                dataType: "html",
                success: function(result){
                  var etapas = JSON.parse(result);
             $('#inputEtapa').find('option').remove().end();
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
        
      });

  $('#inputSubmit').click(function(e) {
    e.preventDefault();
     var etapaID = $('#inputEtapa').val();
      jQuery.ajax({
        type: "POST",
        data: {id:etapaID},
       url: livePath+"/apontador/setHistory",
        dataType: "html",
        success: function(r){
            window.location.href = r;
        }
      });
  });

 /*      $('#inputEtapa').change(function() {
        $('.TypeLoading').show();
        var dadoos = $('#inputEtapa').val();
      jQuery.ajax({
                type: "POST",
                data: {id:dadoos},
               url: "/importador/subetapas",
                dataType: "html",
                success: function(result2){
             var myArrayy = result2.split('&x&');
             var temp;
             $('#inputsubetapa').find('option').remove().end();
             $('#inputsubetapa').append($('<option>', {
          value: 0,
          text: 'Escolha uma Subetapa...'
      }));
            for (var i = 0; i < myArrayy.length; ++i) {
              temp = myArrayy[i].split('&');
           $('#inputsubetapa').append($('<option>', {
          value: temp[0],
          text: temp[1]
      }));
           temp = null;
           };
            $('.TypeLoading').hide();
            $('.inputsubetapa').removeClass('hidden');
                }
            });
        
        
      });

       $('#inputsubetapa').change(function() {
        $('.TypeLoading').show();
         
           var sube = $('#inputsubetapa').val();
           jQuery.ajax({
                type: "POST",
                data: {id:sube},
               url: "/importador/importar",
                dataType: "html",
                success: function(r){
                  var subed = JSON.parse(r);
                  var disables = [1,2,3,4];
                  if(subed.importacaoNr != 0){
                      $('.formSentido').hide();
                  }else{
                    $('.formSentido').removeClass('hidden');
                  }
                  $('#sentido'+subed.sentido).attr('checked', true);
                  $('#toReceiveSubId').val(subed.subetapa_id);
                  
                   $('#noSort').find('td').remove().end();
                  if(subed.importacoes.length > 0){
                    for(var imp in subed.importacoes){
                    //  console.log(subed.importacoes[imp]);
                      $('#noSort tr:last').after("<tr class='tableEtapa'><td class='text-center' ><i id='"+ subed.importacoes[imp].id +"' title='Importacao "+ subed.importacoes[imp].importacaoNr +"' class='clickTable fa fa-plus fa-fw'></i></td><td>"+ subed.importacoes[imp].descricao +"</td><td>"+ subed.importacoes[imp].importacaoNr +"</td><td>"+ subed.importacoes[imp].observacoes +"</td><td><div class='text-center hoverActions'><a style='color:#f5f5f5' id='delete&"+ subed.importacoes[imp].id +"' class='delImp' title='Excluir Importacao' href='' ><i class='fa fa-times'></i></a></div></td></tr>"); 
                      if(subed.importacoes[imp].dbf2d != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/dbf.png" +"'></td><td colspan='3'><p>"+ subed.importacoes[imp].dbf2d +"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].dbf2d +"'><i class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].ifc_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/ifc.png" +"'></td><td colspan='3'><p>"+ subed.importacoes[imp].ifc_orig +"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].ifc_orig +"'><i class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].fbx_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/fbx.png" +"'></td><td colspan='3'><p>"+ subed.importacoes[imp].fbx_orig +"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].fbx_orig +"'><i class='fa fa-download'></i></a></td></tr>");
                      }
                      $('.toBeHidden').hide();
                    }
                  }else{
                    $('#noSort tr:last').after("<tr><td class='text-center emptyTable' colspan='5'>Nenhuma Importação para esta Subetapa</td></tr>"); 
                  }
                  
                  $('.TypeLoading').hide();
                  $('#inputSubmit').removeClass('hidden');
                }

            });
        
       }); */

         $('#importTable').DataTable({
              responsive: true
          });

         $('.toBeHidden').hide();



         $('#dbftogo').submit(function(event) {
           $('#tecnometal').hide();
           $('.loadingImp').show();
         });

         
           $(document).on('click', '.delImp', function(e){
            var data = $(this).attr('id');
            jQuery.ajax({
                type: "POST",
                data: {id:data},
               url: "/importador/excluir",
                dataType: "html",
                success: function(r){
                     window.location.href = r;
                }
            });
            e.preventDefault();
          });


        


    
} );
