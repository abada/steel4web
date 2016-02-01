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
        "bPaginate": false
    });

$('#noSortObra').DataTable({
        responsive: true,
        "ordering": false,
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

/*   $('.clickTable').click(function(e) {
    alert('clickoe');
      var id = event.target.id;
      $('.'+id).toggle();
      $(this).toggleClass('fa-minus fa-plus');
   }); */

  

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

      $('#inputChooseObra').change(function() {
      	$('.TypeLoading').removeClass('hidden');

      	var dados = $('#inputChooseObra').val();
     	jQuery.ajax({
                type: "POST",
                data: {id:dados},
               url: "/importador/etapas",
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
                }
            });
        $('.inputetapa').removeClass('hidden');
        $('.TypeLoading').addClass('hidden'); 
      });

       $('#inputEtapa').change(function() {
        $('.TypeLoading').removeClass('hidden');
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
                }
            });
        $('.inputsubetapa').removeClass('hidden');
        $('.TypeLoading').addClass('hidden'); 
      });

       $('#inputsubetapa').change(function() {
         $('#inputSubmit').removeClass('hidden');
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
                    for(var x=0;x<4;x++){
                      $('#sentido'+disables[x]).attr('disabled',true);
                    }
                    $('.formSentido').hide();
                  }else{
                    $('.formSentido').show();
                  }
                  $('#sentido'+subed.sentido).attr('checked', true);
                  $('#toReceiveSubId').val(subed.subetapa_id);
                  
                   $('#noSort').find('td').remove().end();
                  if(subed.importacoes.length > 0){
                    for(var imp in subed.importacoes){
                    //  console.log(subed.importacoes[imp]);
                      $('#noSort tr:last').after("<tr class='tableEtapa'><td class='text-center' ><i id='"+ subed.importacoes[imp].id +"' title='Importacao "+ subed.importacoes[imp].importacaoNr +"' class='clickTable fa fa-plus fa-fw'></i></td><td>"+ subed.importacoes[imp].descricao +"</td><td>"+ subed.importacoes[imp].importacaoNr +"</td><td>"+ subed.importacoes[imp].observacoes +"</td><td><div class='text-center hoverActions'><a style='color:#f5f5f5' href='"+ subed.editar +"/"+ subed.importacoes[imp].id +"' title='Editar Importacao'> <i class='fa fa-edit fa-fw'></i></a>&nbsp;&nbsp;     <a style='color:#f5f5f5' name='"+ subed.importacoes[imp].id +"' class='delImp' title='Excluir Importacao' href='' ><i class='fa fa-times'></i></a></div></td></tr>"); 
                      if(subed.importacoes[imp].dbf2d != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/dbf.png" +"'></td><td colspan='3'>"+ subed.importacoes[imp].dbf2d +"</td><td class='text-center'><a title='Download' href='"+ subed.download+"/"+subed.importacoes[imp].locatario_id+"/"+subed.importacoes[imp].cliente_id+"/"+subed.importacoes[imp].obra_id+"/"+subed.importacoes[imp].etapa_id+"/"+subed.importacoes[imp].subetapa_id+"/"+subed.importacoes[imp].importacaoNr+"/"+subed.importacoes[imp].dbf2d +"'><i style='color:black' class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].ifc_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/ifc.png" +"'></td><td colspan='3'>"+ subed.importacoes[imp].ifc_orig +"</td><td class='text-center'><a title='Download' href='"+ subed.download+"/"+subed.importacoes[imp].locatario_id+"/"+subed.importacoes[imp].cliente_id+"/"+subed.importacoes[imp].obra_id+"/"+subed.importacoes[imp].etapa_id+"/"+subed.importacoes[imp].subetapa_id+"/"+subed.importacoes[imp].importacaoNr+"/"+subed.importacoes[imp].ifc_orig +"'><i style='color:black' class='fa fa-download'></i></a></td></tr>");
                      }
                      if(subed.importacoes[imp].fbx_orig != null){
                          $('#noSort tr:last').after("<tr class='toBeHidden "+ subed.importacoes[imp].id +"'><td class='img-icon text-center'><img src='"+ subed.image+"/fbx.png" +"'></td><td colspan='3'>"+ subed.importacoes[imp].fbx_orig +"</td><td class='text-center'><a title='Download' href='"+ subed.download+"/"+subed.importacoes[imp].locatario_id+"/"+subed.importacoes[imp].cliente_id+"/"+subed.importacoes[imp].obra_id+"/"+subed.importacoes[imp].etapa_id+"/"+subed.importacoes[imp].subetapa_id+"/"+subed.importacoes[imp].importacaoNr+"/"+subed.importacoes[imp].fbx_orig +"'><i style='color:black' class='fa fa-download'></i></a></td></tr>");
                      }
                      $('.toBeHidden').hide();
                    }
                  }else{
                    $('#noSort tr:last').after("<tr><td class='text-center' colspan='5'>Nenhuma Importação para esta Subetapa</td></tr>"); 
                  }
                  
                  
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

         $('.downloadFileImp').click(function(e) {
           e.preventDefault();
           var data = $(this).attr('id')
           alert(data);
           jQuery.ajax({
                type: "POST",
                data: {data:data},
               url: "/importador/download",
                dataType: "html",
                success: function(result2){
                    var x = 0;
                }
            });
         });


    
} );