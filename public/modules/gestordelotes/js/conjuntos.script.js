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
        var url = urlbase + '/api/obras/' + $('#inputObra').val() + '/etapas/' + $('#inputEtapa').val() + '/subetapas/' + $(this).val() + '/importacoes?has=importacoes';
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

    });


    /* CRIAR LOTE */
    $('#criarlote').click(function(e) {
        e.preventDefault();


        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input.qtd');
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
                    subetapa_id: $('#inputSubetapa').val(),
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
        // });

        // ATUALIZA TABELA
        handlesGrid.ajax.url(urlbase + '/gestordelotes/handles').load();
    });


    /* ASSOCIAR AO LOTE */
    function changelote(e) {

        var selectedItems = handlesGrid.rows('.selected').data();
        var selectedQtd = handlesGrid.$('.selected').find('input');
        var handles_ids = {};

        for (var i = 0; i < selectedItems.length; i++) {
            if (undefined !== handles_ids[selectedItems[i].MAR_PEZ]) {
                handles_ids[selectedItems[i].MAR_PEZ] += parseInt(selectedQtd[i].value, 10);
            } else {
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
                            $('#lotes').append('<li><a href="' + urlbase + '/gestordelotes/associaraolote/' + val.id + '">' + val.descricao + '</a></li>');
                        });
                        $('#lotes').parent().removeClass('hidden');


                        $('#lotes li a').click(function(e) {
                            e.preventDefault();
                            changelote($(this));
                        });

                    })
                    .fail(function() {

                    });

                $('.loading.hidden').removeClass('hidden');
                alert('Conjuntos alterados de lote com sucesso!');
                handlesGrid.ajax.url(urlbase + '/gestordelotes/handles').load();
                $('.loading').addClass('hidden');
                $('#navigation').find('.loteOptions').addClass('hidden');

            });

    };
    $('#lotes li a').click(function(e) {
        e.preventDefault();
        changelote($(this));
    });


    /**
     * DATABLES     
     */
    var colunas = [{
            data: null,
            defaultContent: "",
            className: "select-checkbox",
            orderable: true
        }, {
            data: function(data, type, full) {
                if (type === 'display') {
                    return '<input type="number" name="qtd[' + data.MAR_PEZ + ']" class="form-control input-sm qtd" value="' + data.QTA_PEZ + '" min="1" max="' + data.QTA_PEZ + '" step="1" title="">';
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
            data: "MAR_PEZ"
        }, {
            data: "FLG_DWG"
        },
        // {
        //     data: "DES_PEZ"
        // },
        {
            data: function(data, type, full) {
                if (type === 'display') {
                    return '<form class="DES_PEZ"><input type="text" class="form-control input-sm" name="DES_PEZ[' + data.MAR_PEZ + ']" value="' + data.DES_PEZ + '" title=""><button class="btn btn-success btn-xs hidden" type="submit"><i class="fa fa-save"></i></button><i class="fa-loading fa fa-circle-o-notch fa-spin hidden"></i><i class="fa-success fa fa-check text-success hidden"></i></form>';
                }
                return data.DES_PEZ;
            }
        }, {
            data: function(data, type, full) {
                if (type === 'display') {
                    return '<img src="' + urlbase + '/img/icons/' + data.ICON + '"/>';
                }
                return data.DES_PEZ;
            }
        },
        // {
        //     data: "TRA_PEZ"
        // },
        {
            data: function(data, type, full) {
                if (type === 'display') {
                    return '<form class="TRA_PEZ"><input type="text" class="form-control input-sm" name="TRA_PEZ[' + data.MAR_PEZ + ']" value="' + data.TRA_PEZ + '"><button class="btn btn-success btn-xs hidden" type="submit"><i class="fa fa-save"></i></button><i class="fa-loading fa fa-circle-o-notch fa-spin hidden"></i><i class="fa-success fa fa-check text-success hidden"></i></form>';
                    // return '<input type="text" name="TRA_PEZ['+data.MAR_PEZ+']" class="form-control input-sm" value="' + data.TRA_PEZ + '" title="">';
                }
                return data.TRA_PEZ;
            }
        }, {
            data: "estagio"
        }
    ];
    //var cols = $.merge(colunas, columns); //columns vem por js        
    

    // CHANGE TRA_PEZ e DES_PEZ
    var buildforms = function () {
        $('form.DES_PEZ input, form.TRA_PEZ input').keyup(function() {
            $(this).next('.btn.hidden').removeClass('hidden');            
        });
        $('form.DES_PEZ, form.TRA_PEZ').on('click', '.btn', function(event) {
            event.preventDefault();     

            var form = $(this).parent();
            var submit = $(this);       
            var success = form.find('i.fa-success');
            var loading = form.find('i.fa-loading');
            
            $.ajax({
                url: urlbase + '/gestordelotes/handles',
                type: 'POST',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function(el) { 
                    loading.removeClass('hidden');
                    submit.addClass('hidden');
                },
                headers:
                {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            })
            .done(function(data) {
               loading.addClass('hidden');
               success.removeClass('hidden');
               setTimeout(function() {
                    success.addClass('hidden');
               }, 1000);
            })
            .fail(function() {
            })
            .always(function() {
            });
        });

        

        // $('form.TRA_PEZ').on('click', '.btn', function(event) {
        //     event.preventDefault();
        // });
    }

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
            columns: colunas,
            select: {
                style: 'multi',
                selector: 'tr td.select-checkbox'
            },
            rowCallback: function(row, data) {
                if ($.inArray(String(data.id), selected) !== -1) {
                    $(row).addClass('selected');
                }
            },
            drawCallback: function( settings ) {
                buildforms();
            },
            language: {
                "decimal":        "",
                "emptyTable":     "Sem dados ara exibir",
                "info":           "Exibindo _START_ à _END_ de _TOTAL_ registros",
                "infoEmpty":      "Exibindo 0 à 0 de 0 registros",
                "infoFiltered":   "(filtrado de _MAX_ registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Exibir _MENU_ registros",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "search":         "Procurar:",
                "zeroRecords":    "Sem dados para exibir",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
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

    
    if ($('#inputObra').val() || $('#inputEtapa').val() || $('#inputSubetapa').val()) {
        $('.inputobra.hidden').removeClass('hidden');
        $('.inputetapa.hidden').removeClass('hidden');
        $('.inputsubetapa.hidden').removeClass('hidden');
        $('#getHandles.hidden').removeClass('hidden');
        $('#getHandles').trigger('click');
    }

});
