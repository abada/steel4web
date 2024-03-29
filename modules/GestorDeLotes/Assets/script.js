$(document).ready(function($) {

    // var urlbase = '{!! env("APP_URL") !!}';
    // console.log(urlbase);

    // OBRA CHANGE
    $('#inputObra').change(function(event) {

        // 	obter etapas
        $.ajax({
                url: urlbase + '/api/obras/' + $(this).val() + '/etapas',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('.loading.hidden').removeClass('hidden');
                    $('.inputetapa, .inputGrouped, #getHandles').addClass('hidden');
                }
            })
            .done(function(data) {
                $('#inputEtapa').html('');
                $('.loading').addClass('hidden');
                $('.inputetapa.hidden, .inputGrouped.hidden, #getHandles.hidden').removeClass('hidden');

                $.each(data, function(index, val) {
                    $('#inputEtapa').append('<option value="' + val.id + '">' + val.codigo + '</option>');
                });
            })
            .fail(function() {

            });

    });

    $('#inputObra').trigger('change');

    // if( etapa_id ){
    // 	$('.inputetapa.hidden, .inputGrouped.hidden, #getHandles.hidden').removeClass('hidden');
    // }else{
    // 	$('#inputObra').trigger('change');
    // }

    // ON ETAPA CHANGE
    $('#inputEtapa').change(function(event) {

        // 	obter subetapas
        $.ajax({
                url: urlbase + '/api/obras/' + $('#inputObra').val() + '/etapas/' + $(this).val() + '/subetapas',
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('.loading.hidden').removeClass('hidden');
                    $('.inputGrouped, #getHandles').addClass('hidden');
                }
            })
            .done(function(data) {
                $('#inputSubetapa').html('');
                $('.loading').addClass('hidden');
                $('.inputsubetapa.hidden, .inputGrouped.hidden, #getHandles.hidden').removeClass('hidden');

                $.each(data, function(index, val) {
                    $('#inputSubetapa').append('<option value="' + val.id + '">' + val.cod + '</option>');
                });
            })
            .fail(function() {

            });

    });


    // ON SUBETAPA CHANGE
    $('#inputSubetapa').change(function(event) {

        // LOAD TABLE
        var url = urlbase + '/api/obras/' + $('#inputObra').val() + '/etapas/' + $('#inputEtapa').val() + '/subetapas/' + $(this).val() + '/importacoes';

        console.log(url);

        // handlesGrid.ajax.url( url ).load();

    });





    // ON CLICK AT ROW
    $('#handlesGrid tbody').on('click', 'tr', function(e, dt, type, indexes) {
        // SHOW/HIDE options
        if (handlesGrid.rows('.selected').data().length) {
            $('#createLoteForm').find('.loteOptions.hidden').removeClass('hidden');
        } else {
            $('#createLoteForm').find('.loteOptions').addClass('hidden');
        };


        var data = handlesGrid.rows('.selected').data().pluck('id');
        selected = $.makeArray(data);
        selected = data;


        // // var id = this.id;
        // var indx = $.inArray(data[0], selected);

        // if ( indx === -1 ) {
        //     selected.push( data[0] );
        // } else {
        //     selected.splice( indx, 1 );
        // }

    });



    /* On form change */
    $('#createLoteForm').change(function() {
        // $(this).find('.loteOptions').addClass('hidden');
        // $('#getHandles').trigger('click');
    });

    /* CRIAR LOTE */
    $('#criarlote').click(function(e) {
        e.preventDefault();

        var selectedIds = handlesGrid.rows('.selected').data();
        var handles_ids = Array();

        for (var i = 0; i < selectedIds.length; i++) {
            handles_ids.push(selectedIds[i].id);
        };
        $('#inputHandleIds').val(handles_ids.join(","));

        $.ajax({
                url: urlbase + '/gestordelotes/handles',
                type: 'GET',
                dataType: 'html',
                data: {
                    obra_id: $('#inputObra').val(),
                    etapa_id: $('#inputEtapa').val(),
                    // handles_ids: $('#inputHandleIds').val(),
                    handles_ids: handles_ids,
                    grouped: $('#inputGrouped:checked').val(),
                }
            })
            .done(function(data) {

                $('#modal').find('.modal-content').html(data);

            })
            .fail(function() {

            })
            .always(function() {

            });


    });

    /* GET HANDLES */
    $('#getHandles').click(function() {
        handlesGrid.ajax.url(urlbase + '/gestordelotes/handles').load();
    });

    var handlesGrid = $('#handlesGrid').DataTable({
        ajax: {
            url: urlbase + '/gestordelotes/handles',
            data: function(d) {
                // d.grouped = $('#inputGrouped:checked').val();
                d.obra = $('#inputObra').val();
                d.etapa = $('#inputEtapa').val();
                d.subetapa = $('#inputSubetapa').val();
            }
        },
        scrollX: true,
        responsive: true,
        columns,
    });

    // var handlesGrid = $('#handlesGrid').DataTable({
    // 	ajax: {
    // 		url: 	'http://steel4web.dev/steel4web/public/gestordelotes/handles',
    // 		data: 	function ( d ) {
    // 			// d.grouped = $('#inputGrouped:checked').val();
    // 			// d.obra = $('#inputObra').val();
    // 			// d.etapa = $('#inputEtapa').val();
    // 			// d.subetapa = $('#inputSubetapa').val();
    // 		}
    // 	},
    // 	scrollX: true,
    // 	responsive: true,
    // 	columns: [
    // 		{
    // 			data: 			null,
    // 			defaultContent: '',
    // 			className: 		'select-checkbox',
    // 			orderable: 		true,
    // 		},
    // 		{ data: 'importacao_id' },
    // 		{ data: 'lote' },
    // 		{ data: 'MAR_PEZ' },
    // 		{ data: 'FLG_DWG' },
    // 		{ data: 'QTA_PEZ' },
    // 		{ data: 'DES_PEZ' },
    // 		{ data: 'TRA_PEZ' },
    // 		{ data: 'id' }
    // 	],
    // 	select: {
    // 		style:    'multi',
    // 		selector: 'tr'
    // 	}
    // });

});
