$(document).ready(function() {

	$('#inputRelObra').change(function(event) {
		$('#inputSubmit').removeClass('hidden');
	});

	

	 var relObraTable = $('#relObraTable').DataTable({
            ajax: {
              type: 'GET',
              url: getConjuntosObra()
            },
            scrollX: true,
            responsive: true,
            columns:  [
            { "data": "nome" },
            { "data": "cliente"},
            { "data": "descricao" },
        ],
            "language": {
              "emptyTable": "Nenhum Conjunto Disponivel."
            },
        });

	$('#inputSubmit').click(function(event) {
		relObraTable.ajax.url(getConjuntosObra()).load();
	});
});

function getConjuntosObra(first){
  var obra     = $('#inputRelObra').val();
       return (urlbaseGeral + '/relatorios/getConjuntosObra/'+obra);
        
}