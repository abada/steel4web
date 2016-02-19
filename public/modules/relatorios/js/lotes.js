$(document).ready(function() {

	$('#inputRelObra').change(function(event) {
		$('#inputSubmit').removeClass('hidden');
	});

	

	 var Table = $('#relLotesTable').DataTable({
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
  var lote     = $('#inputRelLoteLote').val();
       return (urlbaseGeral + '/relatorios/getConjuntos/lotesXxX'+lote);
        
}