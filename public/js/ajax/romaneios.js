$(document).ready(function() {


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
        
      });

      $('#inputEtapa').change(function() {
        $('.TypeLoading').show();

        var dados = $('#inputEtapa').val();
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
        
      });

      $('#inputSubetapa').change(function() {
        $('.TypeLoading').show();

        var sub = $('#inputSubetapa').val();
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
    
} );

function isset(object){
    return (typeof object !=='undefined');
}

$(document).on('blur', '.nfInput', function(){
  var flag = true;
  $('.nfInput').each(function() {
        if ($.trim($(this).val()) == '') {
            flag = false;
        }
        else {
            console.log('banana');

        }
    });

    if(flag === true){
      $('#nfInputs').append('<input name="nf[]" class="form-control nfInput" type="text">');
    }else{
      if($(this).length < 1){
        console.log($(this).length);
        $(this).last().remove();
      }
      
    }
    

  });