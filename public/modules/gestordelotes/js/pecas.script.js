$(document).ready(function($) {

    // OBRA CHANGE
    $('#inputObra').change(function(event) {

        //  obter etapas
        $.ajax({
                url: urlbase + '/api/obras/' + $(this).val() + '/etapas?has=importacoes',
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
                $('.inputetapa.hidden').removeClass('hidden');

                $('#inputEtapa').append('<option>-- Selecione a etapa --</option>');
                $.each(data, function(index, val) {
                    $('#inputEtapa').append('<option value="' + val.id + '">' + val.codigo + '</option>');
                });
            })
            .fail(function() {

            });

    });

    // if( null == $('#inputObra:selected').val() ){
    //     $("#inputObra")[0].selectedIndex = 1;
    //     $('#inputObra').trigger('change');       
    // }

    // ON ETAPA CHANGE
    $('#inputEtapa').change(function(event) {

        //  obter subetapas
        $.ajax({
                url: urlbase + '/api/obras/' + $('#inputObra').val() + '/etapas/' + $(this).val() + '/subetapas?has=importacoes',
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
                $('.inputsubetapa.hidden').removeClass('hidden');

                $('#inputSubetapa').append('<option>-- Selecione a subetapa --</option>');
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
        $('#getHandles.hidden').removeClass('hidden');

    });





    // ON CLICK AT ROW
    $('#handlesGrid tbody').on('click', 'tr', function(e, dt, type, indexes) {
        // SHOW/HIDE options
        if (handlesGrid.rows('.selected').data().length) {
            $('#navigation').find('.loteOptions.hidden').removeClass('hidden');
        } else {
            $('#navigation').find('.loteOptions').addClass('hidden');
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
    $('#navigation').change(function() {
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
                url: urlbase + '/gestordelotes/criar',
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
    $('#getHandles').click(function(e) {

        e.preventDefault();

        var navdata = $('#navigation').serialize();

        $('#navigation ul li').each(function(index, el) {
            var a = $(this).find('a');            
            var old_fulladdr = a.attr('href');
            var old_addr_parts = old_fulladdr.split('?');
            a.attr('href', old_addr_parts[0] + '?' + navdata);
        });

        // // SALVA NAVEGAÇÃO NA SESSION
        // $.ajax({
        //     url: urlbase + '/gestordelotes/buildnavigation',
        //     type: 'GET',
        //     dataType: 'json',
        //     data: navdata
        // })
        // .done(function(data) {
        //     console.log(data);
        // });


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
                    d.flg_rec = 4;
                }
            },
            scrollX: true,
            responsive: true,
            columns: [{ data: 'importacao_id' },
                { data: 'POS_PEZ' },
                { data: 'QTA_PEZ' },
                // { data: 'NOM_PRO' },
                // { data: 'CATE' },
                { data:
                    function (data, type, full) {
                        if (type === 'display' && data.CATE <= 30) {  
                            console.log(data.NOM_PRO);
                            if( data.NOM_PRO ){
                                return '<img src="'+urlbase+'/img/icons/'+data.CATE+'.png" /> &nbsp; '+data.NOM_PRO;
                            }else{
                                return '<img src="'+urlbase+'/img/icons/'+data.CATE+'.png" /> &nbsp; CHAPA #'+' '+data.SPE_PRO;
                            }
                        }
                        return data.CATE;
                    }
                }],
            select: {
                style: 'multi',
                selector: 'tr'
            },
            rowCallback: function(row, data) {

                if ($.inArray(String(data.id), selected) !== -1) {
                    $(row).addClass('selected');
                }
            }
        })
        .on('preXhr.dt', function(e, settings, data) {
            $('.loading.hidden').removeClass('hidden');
        })
        .on('xhr.dt', function(e, settings, json, xhr) {
            $('.loading').addClass('hidden');
        })
        .on('select', function(e, dt, type, indexes) {
            handlesGrid[type](indexes).nodes().to$().addClass('selected');
        });


    if( $('#inputObra').val() || $('#inputEtapa').val() || $('#inputSubetapa').val() ){
        $('.inputobra.hidden').removeClass('hidden');
        $('.inputetapa.hidden').removeClass('hidden');
        $('.inputsubetapa.hidden').removeClass('hidden');
        $('#getHandles.hidden').removeClass('hidden');
        $('#getHandles').trigger('click');
    }


});
