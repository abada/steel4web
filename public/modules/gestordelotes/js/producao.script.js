$(document).ready(function($) {

    // OBRA CHANGE
    $('#inputObra').change(function(event) {

        //  obter etapas
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

    
        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input');
        var handles_ids = {};        

        for (var i = 0; i < selectedItems.length; i++) {        
            // handles_ids[selectedItems[i].id] = selectedQtd[i].value;          
            handles_ids[selectedItems[i].MAR_PEZ] = selectedQtd[i].value;
        };        

        $.ajax({
                url: urlbase + '/gestordelotes/criar',
                type: 'GET',
                dataType: 'html',
                data: {
                    obra_id: $('#inputObra').val(),
                    etapa_id: $('#inputEtapa').val(),
                    // handles_ids: $('#inputHandleIds').val(),
                    grouped: $('#inputGrouped:checked').val(),
                    handles_ids: handles_ids,
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
        console.log(navdata);

        $('#navigation ul li').each(function(index, el) {
            var a = $(this).find('a');            
            var old_fulladdr = a.attr('href');
            var old_addr_parts = old_fulladdr.split('?');
            a.attr('href', old_addr_parts[0] + '?' + navdata);
        });

        // SALVA NAVEGAÇÃO NA SESSION
        // $.ajax({
        //     url: urlbase + '/gestordelotes/buildnavigation',
        //     type: 'GET',
        //     dataType: 'json',
        //     data: navdata
        // })
        // .done(function(data) {
        //     console.log(data);
        // });

        handlesGrid.ajax.url(urlbase + '/gestordelotes/producao/handles').load();    
    });


    /* REMOVE CONJUNTOS */
    $('#removerconjuntos').click(function(e) {    

        e.preventDefault();
    
        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input');
        var handles_ids = {};        

        for (var i = 0; i < selectedItems.length; i++) {             
            if( undefined !== handles_ids[selectedItems[i].MAR_PEZ] ){
                handles_ids[selectedItems[i].MAR_PEZ] += parseInt(selectedQtd[i].value, 10);
            }else{
                handles_ids[selectedItems[i].MAR_PEZ] = parseInt(selectedQtd[i].value, 10);
            }
        };                

        $.ajax({
                url: urlbase + '/gestordelotes/lotes/remover',
                type: 'GET',
                dataType: 'json',
                data: {                    
                    handles_ids: handles_ids,
                }
            })
            .done(function(data) {

                console.log(data);
                alert( "Itens removidos do lote!" );
                handlesGrid.ajax.url(urlbase + '/gestordelotes/producao/handles').load();

            })
            .fail(function() {

            })
            .always(function() {

            });

    });

    /* REMOVE LOTE */
    $('#removerlote').click(function(e) {    

        e.preventDefault();
    
        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input');
        var lotes = [];            

        for (var i = 0; i < selectedItems.length; i++) {
            if( $.inArray( selectedItems[i].lote_id, lotes) == -1 ){
                lotes.push(selectedItems[i].lote_id);
            };
        };        

        if( confirm('Isto irá remover o Lote inteiro incluindo seu cronograma. Deseja mesmo continuar?') ){
            $.ajax({
                url: urlbase + '/gestordelotes/lotes/removerlote',
                type: 'GET',
                dataType: 'json',
                data: {                    
                    lotes: lotes,
                }
            })
            .done(function(data) {

                console.log(data);
                if( data.length > 1 ){
                    alert( data.length + " Lotes removidos!" );                        
                }else{
                    alert( data.length + " Lote removido!" );                        
                }
                handlesGrid.ajax.url(urlbase + '/gestordelotes/producao/handles').load();

            });
        }

    });

    /* ENVIAR LOTEs */
    $('#enviarlotes').click(function(e) {    

        e.preventDefault();

        alert('Função indisponível');
    
        // var selectedItems = handlesGrid.rows('.selected').data();
        // var selectedQtd = handlesGrid.$('.selected').find('input');
        // var lotes = [];            

        // for (var i = 0; i < selectedItems.length; i++) {
        //     if( $.inArray( selectedItems[i].lote_id, lotes) == -1 ){
        //         lotes.push(selectedItems[i].lote_id);
        //     };
        // };        

        // if( confirm('Isto irá remover o Lote inteiro incluindo seu cronograma. Deseja mesmo continuar?') ){
        //     $.ajax({
        //         url: urlbase + '/gestordelotes/lotes/removerlote',
        //         type: 'GET',
        //         dataType: 'json',
        //         data: {                    
        //             lotes: lotes,
        //         }
        //     })
        //     .done(function(data) {

        //         console.log(data);
        //         if( data.length > 1 ){
        //             alert( data.length + " Lotes removidos!" );                        
        //         }else{
        //             alert( data.length + " Lote removido!" );                        
        //         }
        //         handlesGrid.ajax.url(urlbase + '/gestordelotes/lotes/handles').load();

        //     });
        // }

    });


    /* ASSOCIAR AO LOTE */
    function changelote(e) {   
    
        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input');
        var handles_ids = {};        

        for (var i = 0; i < selectedItems.length; i++) {             
            if( undefined !== handles_ids[selectedItems[i].MAR_PEZ] ){
                handles_ids[selectedItems[i].MAR_PEZ] += parseInt(selectedQtd[i].value, 10);
            }else{
                handles_ids[selectedItems[i].MAR_PEZ] = parseInt(selectedQtd[i].value, 10);
            }
        };                

        $.ajax({
                url: e.attr('href'),
                type: 'GET',
                dataType: 'json',
                data: {                    
                    handles_ids: handles_ids,
                }
            })
            .done(function(data) {                

                $.ajax({
                    url: urlbase + '/api/lotes',
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('.loading.hidden').removeClass('hidden');
                        $('#lotes').parent().addClass('hidden');
                    }
                })
                .done(function(lotes) {
                    $('#lotes').html('');
                    $('.loading').addClass('hidden');
                    
                    $.each(lotes, function(index, val) {
                        $('#lotes').append('<li><a href="' + urlbase + '/gestordelotes/lotes/' + val.id + '/associar">' + val.descricao + '</a></li>');
                    });
                    $('#lotes').parent().removeClass('hidden');


                    $('#lotes li a').click(function (e) {
                        e.preventDefault();
                        changelote($(this));
                    });

                })
                .fail(function() {

                });
                
                $('.loading.hidden').removeClass('hidden');
                handlesGrid.ajax.url(urlbase + '/gestordelotes/producao/handles').load();
                $('.loading').addClass('hidden');
                $('#navigation').find('.loteOptions').addClass('hidden');             

            });

    };
    $('#lotes li a').click(function (e) {
        e.preventDefault();        
        changelote( $(this) );
    });






    /**
     * DATATABLES
     */
    var colunas = [{
        data: null,
        defaultContent: "",
        className: "select-checkbox",
        orderable: false
    }, {
        data: function(data, type, full) {
            if (type === 'display') {
                return '<input type="number" name="qtd['+data.MAR_PEZ+']" class="form-control input-sm" value="' + data.QTA_PEZ + '" min="1" max="' + data.QTA_PEZ + '" step="1" title="">';
            }
            return null;
        },
        className: "input-qtd",
        orderable: false
    }, {
        data: "QTA_PEZ"
    }, {
        data: "importacao_id"
    }, {
        data: "lote"
    }, {
        data: "MAR_PEZ"
    }, {
        data: "FLG_DWG"
    }, {
        data: function(data, type, full) {
            if (type === 'display') {
                return '<img src="'+urlbase+'/img/icons/' + data.DES_PEZ + '"/>';
            }
            return data.DES_PEZ;
        }
    }, {
        data: "TRA_PEZ"
    }, {
        data: "estagio"
    }];
    var cols = $.merge(colunas, columns); //columns vem por js        

    var handlesGrid = $('#handlesGrid').DataTable({
            ajax: {
                url: urlbase + '/gestordelotes/producao/handles',
                data: function(d) {
                    // d.grouped = $('#inputGrouped:checked').val();
                    d.obra = $('#inputObra').val();
                    d.etapa = $('#inputEtapa').val();
                    d.subetapa = $('#inputSubetapa').val();
                }
            },
            scrollX: true,
            responsive: true,
            columns: colunas,
            select: {
                style: 'multi',
                selector: 'tr td.select-checkbox'
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