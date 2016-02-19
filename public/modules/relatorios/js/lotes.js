$(document).ready(function() {
  $('#TypeLoading').hide();

	$('#obra').change(function(event) {
		$('.formSub').addClass('hidden');
    $('.formLote').addClass('hidden');
    $('#inputSubmit').addClass('hidden');
    $('#TypeLoading').show();

    var dados = $('#obra').val();
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/obras/"+dados+"/etapas?has=lotes",
          dataType: "json",
          success: function(result){
            var etapas = result;
       $('#etapa').find('option').remove().end();
       $('#etapa').append($('<option>', {
          value: 0,
          text: 'Selecione uma Etapa...'
      }));
       $.each(etapas, function (index, etapa){                       
             $('#etapa').append($('<option>', {
            value: etapa.id,
            text: etapa.codigo
        }));
        });
      $('.TypeLoading').hide();
      $('.formEtapa').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }

	});

  $('#etapa').change(function(event) {
    $('.formLote').addClass('hidden');
    $('#inputSubmit').addClass('hidden');
    $('#TypeLoading').show();

    var dados = $('#etapa').val();
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/etapas/"+dados+"/subetapas?has=lotes",
          dataType: "json",
          success: function(result){
            var etapas = result;
       $('#sub').find('option').remove().end();
       $('#sub').append($('<option>', {
          value: 0,
          text: 'Selecione uma Subetapa...'
      }));
       $.each(etapas, function (index, sub){                  
             $('#sub').append($('<option>', {
            value: sub.id,
            text: sub.cod
        }));
        });
      $('.TypeLoading').hide();
      $('.formSub').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }

  });

  $('#sub').change(function(event) {
    $('#TypeLoading').show();

    var dados = $('#sub').val();
      if(dados != 0){
      jQuery.ajax({
          type: "GET",
         url: urlbaseGeral+"/api/subetapas/"+dados+"/lotes",
          dataType: "json",
          success: function(result){
            var etapas = result;
       $('#lote').find('option').remove().end();
       $('#lote').append($('<option>', {
          value: 0,
          text: 'Selecione um Lote...'
      }));
       $.each(etapas, function (index, lote){                  
             $('#lote').append($('<option>', {
            value: lote.id,
            text: lote.descricao
        }));
        });
      $('.TypeLoading').hide();
      $('.formLote').removeClass('hidden');
      $('#inputSubmit').removeClass('hidden');
          }
      });
      }else{
        $('.TypeLoading').hide(); 
      }

  });



	 var Table = $('#relTable').DataTable({
            ajax: {
              type: 'GET',
              url: getConjuntos()
            },
            scrollX: true,
            responsive: true,
            columns:  [
            { "data": "marcas" },
            { "data": "qtd"},
            { "data": "peso_unid" },
            { "data": "peso_tot" },
        ],
            "language": {
              "emptyTable": "Nenhum Conjunto Disponivel."
            },
        });

	$('#inputSubmit').click(function(event) {
		Table.ajax.url(getConjuntos()).load();
	});
});

function getConjuntos(first){
  var lote     = $('#lote').val();
       return (urlbaseGeral + '/relatorios/getConjuntos/lotesXxX'+lote);
        
}