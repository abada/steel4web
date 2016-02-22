$(document).ready(function() {

  $('.closePanel').click(function(e) {
    e.preventDefault();
    $(this).parent('.panel-heading').parent('.panel').fadeOut('fast');
  });

  $('#dataTables').DataTable({
        responsive: true
    });


$('#noSort').DataTable({
        responsive: true,
        "ordering": false,
        "bInfo" : false,
        "bLengthChange": false,
        bFilter: false,
        "bPaginate": false,
        "language": {
          "emptyTable": "Navegue pelos campos acima para visualizar suas importações"
        }
    });

$('#noSortObra').DataTable({
        responsive: true,
        "ordering": false,
        "iDisplayLength": 50,
        "bInfo" : false
    });

//$('.toBeHidden').hide();

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

      $('.loadingImp').hide();
      $('.TypeLoading').hide();
      $('.inputObr').removeClass('hidden');

      $('#inputChooseObra').change(function() {
      	$('.TypeLoading').show();
        $('.inputsubetapa').addClass('hidden');
        $('#inputSubmit').addClass('hidden');

      	var dados = $('#inputChooseObra').val();
     	jQuery.ajax({
                type: "POST",
                data: {id:dados},
               url: urlbaseGeral+"/importador/etapas",
                dataType: "html",
                success: function(result){
             var myArray = result.split('&x&');
             var temp;
             $('#inputEtapa').find('option').remove().end();
             $('#inputEtapa').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
           	for (var i = 0; i < myArray.length; ++i) {
           		temp = myArray[i].split('&');
           $('#inputEtapa').append($('<option>', {
			    value: temp[0],
			    text: temp[1]
			}));
           temp = null;
           };
            $('.TypeLoading').hide();
            $('.inputetapa').removeClass('hidden');
       
                }
            });
        
      });

       $('#inputEtapa').change(function() {
        $('.TypeLoading').show();
        $('#inputSubmit').addClass('hidden');
        var dadoos = $('#inputEtapa').val();
      jQuery.ajax({
                type: "POST",
                data: {id:dadoos},
               url: urlbaseGeral+"/importador/subetapas",
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
               url: urlbaseGeral+"/importador/importar",
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
                      var idSize = subed.importacoes[imp].id;
                      $('#noSort tr:last').after("<tr class='tableEtapa'><td class='text-center' ><i id='"+ subed.importacoes[imp].id +"' title='Importacao "+ subed.importacoes[imp].importacaoNr +"' class='clickTable fa fa-plus fa-fw'></i></td><td>"+ subed.importacoes[imp].descricao +"</td><td>"+ subed.importacoes[imp].importacaoNr +"</td><td>"+ subed.importacoes[imp].observacoes +"</td><td>"+subed.importacoes[imp].locatario_id+"."+subed.importacoes[imp].cliente_id+"."+subed.importacoes[imp].obra_id+"."+subed.importacoes[imp].etapa_id+"."+subed.importacoes[imp].subetapa_id+"."+subed.importacoes[imp].importacaoNr+"</td><td><div class='text-center hoverActions'><a style='color:#222222' id='delete&"+ subed.importacoes[imp].id +"' class='delImp' title='Excluir Importacao' href='' ><i class='fa fa-trash'></i></a></div></td></tr>"); 
                      if(subed.importacoes[imp].dbf2d != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/dbf.png" +"'></td><td colspan='4'><p>"+ subed.importacoes[imp].dbf2d +"   &nbsp;-&nbsp;   "+subed.sizes[idSize].dbf2d+"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].dbf2d.replace('.','DdxdD') +"'><i class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].ifc_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/ifc.png" +"'></td><td colspan='4'><p>"+ subed.importacoes[imp].ifc_orig +"   &nbsp;-&nbsp;   "+subed.sizes[idSize].ifc_orig+"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].ifc_orig.replace('.','DdxdD') +"'><i class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].fbx_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/fbx.png" +"'></td><td colspan='4'><p>"+ subed.importacoes[imp].fbx_orig +"   &nbsp;-&nbsp;   "+subed.sizes[idSize].fbx_orig+"</p></td><td class='text-center'><a class='btn btn-download btn-block' title='Download' target='_blank' href='"+ subed.download +"/"+ subed.importacoes[imp].locatario_id+"&"+subed.importacoes[imp].cliente_id+"&"+subed.importacoes[imp].obra_id+"&"+subed.importacoes[imp].etapa_id+"&"+subed.importacoes[imp].subetapa_id+"&"+subed.importacoes[imp].importacaoNr+"&"+subed.importacoes[imp].fbx_orig.replace('.','DdxdD') +"'><i class='fa fa-download'></i></a></td></tr>");
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
        
       });

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
               url: urlbaseGeral+"/importador/excluir",
                dataType: "html",
                success: function(r){
                     window.location.href = r;
                }
            });
            e.preventDefault();
          });   
} );