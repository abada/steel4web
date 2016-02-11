$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    // Inicio das regras de gravação de etapas do saas
    jQuery("#form-etapa").submit(function(e){
        e.preventDefault();
        var codigoEtapa         = $("#codigoEtapa").val();
        var peso                = $("#peso").val();
        var obraID              = $("#obraID").val();
        var observacao          = $("#observacao").val();

        if (obraID != '' && codigoEtapa != '' && peso != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {codigo:codigoEtapa, peso:peso,  obra_id:obraID, observacao:observacao},
                url: urlbaseGeral+"/etapa/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#codigoEtapa").val('');
                        $("#peso").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
        
    });

    jQuery("#form-etapa-edita").submit(function(e){
        e.preventDefault();
        var codigoEtapa         = $("#codigoEtapa").val();
        var peso                = $("#peso").val();
        var obraID              = $("#obraID").val();
        var observacao          = $("#observacao").val();
        var etapaID          = $("#etapaID").val();

        if (obraID != '' && codigoEtapa != '' && peso != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {codigo:codigoEtapa, peso:peso,  obra_id:obraID, observacao:observacao, etapaID:etapaID},
                url: urlbaseGeral+"/etapa/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
         e.preventDefault();
    });
    //Termino Etapas


    // Inicio das regras de gravação de subetapas
    $("#form-subetapa").submit(function(e){
        e.preventDefault();
        var cod                 = $("#codigoSubetapa").val();
        var peso                = $("#peso").val();
        var tipo                = $("#tipo").val();
        var observacao          = $("#observacao").val();
        var etapa_id            = $('#etapaID').val();

        if (cod != '' && tipo != '' && peso != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {cod:cod, peso:peso,  etapa_id:etapa_id, observacao:observacao, tiposubetapa_id:tipo},
                url: urlbaseGeral+"/subetapa/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#codigoEtapa").val('');
                        $("#peso").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
        
    });

    $("#form-subetapa-edita").submit(function(e){
        e.preventDefault();
        var cod                 = $("#codigoSubetapa").val();
        var peso                = $("#peso").val();
        var tipo                = $("#tipo").val();
        var observacao          = $("#observacao").val();
        var etapa_id            = $('#etapaID').val();
        var id                  = $('#subetapaID').val();

        if (cod != '' && tipo != '' && peso != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {cod:cod, peso:peso,  etapa_id:etapa_id, observacao:observacao, tiposubetapa_id:tipo,id:id},
                url: urlbaseGeral+"/subetapa/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
         e.preventDefault();
    });
    //TErmino Subetapas


    // Inicio das regras de gravação de usuários do saas
    jQuery("#form-obra").submit(function(e){
        $.fn.serializeAndEncode = function() {
    return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
    }).join('&');
};

       var data = $("#form-obra").serializeAndEncode();

        if (data) {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {dados:data}, 
                url: urlbaseGeral+"/obra/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#codigo").val('');
                        $("#nome").val('');
                        $("#descricao").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-obra-edita").submit(function(e){
       $.fn.serializeAndEncode = function() {
    return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
    }).join('&');
};

       var data = $("#form-obra-edita").serializeAndEncode();
          if (data) {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {dados:data}, 
                url: urlbaseGeral+"/obra/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Verifique os campos obrigatórios!');
         }
         e.preventDefault();
    });
    //Fim das regras de gravação de OBRAS


    // Inicio das regras de gravação de usuários do saas
    jQuery("#form-usuario").submit(function(e){
        var nome          = $("#nome").val();
        var email         = $("#email").val();
        var senha         = $("#senha").val();
        var tipoUsuarioID = $("#tipoUsuarioID").val();

        if ( nome != '' && email != '' && senha != '' && tipoUsuarioID != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {nome:nome, email:email, senha:senha, tipoUsuarioID:tipoUsuarioID},
                url: Basepath + "/saas/usuarios/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#nome").val('');
                        $("#email").val('');
                        $("#senha").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-usuario-edita").submit(function(e){
            var nome          = $("#nome").val();
            var email         = $("#email").val();
            var senha         = $("#senha").val();
            var tipoUsuarioID = $("#tipoUsuarioID").val();
            var usuarioLocatarioID = $("#usuarioLocatarioID").val();

            if ( nome != '' && email != '' && senha != '' && tipoUsuarioID != '' && usuarioLocatarioID != '') {
                $('#tipoError2').addClass('hidden');
                $('#tipoError').addClass('hidden');
                $('#tipoSuccess').addClass('hidden');
                $('#tipoLoading').removeClass('hidden');
                jQuery.ajax({
                    type: "POST",
                    data: {nome:nome, email:email, senha:senha, tipoUsuarioID:tipoUsuarioID, usuarioLocatarioID:usuarioLocatarioID},
                    url: Basepath + "/saas/usuarios/gravarEdicao",
                    dataType: "html",
                    success: function(result){
                        if (result.substring(0,7) == 'sucesso') {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoSuccess').removeClass('hidden');
                            $('#tipoError').addClass('hidden');
                            $('#tipoError2').addClass('hidden');
                            $("#nome").val('');
                            $("#email").val('');
                            $("#senha").val('');
                        } else {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoError2').removeClass('hidden');
                            $('#tipoSuccess').addClass('hidden');
                        }
                    },
                    error: function(result){
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    },
                });
             } else {
                alert('Todos os campos são obrigatórios!');
             }
             e.preventDefault();
        });
    //Fim das regras de gravação de usuários SAAS

    // Inicio das regras de gravação de clientes
    jQuery("#form-cliente").submit(function(e){
          e.preventDefault();
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var tipo      = $("#tipo").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var site    = $("#site").val();
        var responsavel    = $("#responsavel").val();
        var endereco  = $("#endereco").val();
        var cidade  = $("#cidade").val();
        var cep       = $("#cep").val();



        if ( razao != '' && tipo != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {razao:razao,cidade:cidade, fantasia:fantasia, email:email, tipo:tipo, documento:documento, inscricao:inscricao, telefone:telefone, site:site, responsavel:responsavel, endereco:endereco, cep:cep},
                url: urlbaseGeral+"/cliente/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#email").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#inscricao").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Preenncha os campos obrigatórios!');
         }
       
    });

    jQuery("#form-cliente-edita").submit(function(e){
        e.preventDefault();
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var tipo      = $("#tipo").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var site    = $("#site").val();
        var responsavel    = $("#responsavel").val();
        var endereco  = $("#endereco").val();
        var cep       = $("#cep").val();
        var cidade       = $("#cidade").val();
        var id       = $("#id").val();

        if ( razao != '' && tipo != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {id:id, razao:razao, cidade:cidade, fantasia:fantasia, email:email, tipo:tipo, documento:documento, inscricao:inscricao, telefone:telefone, site:site, responsavel:responsavel, endereco:endereco, cep:cep},
                url: urlbaseGeral+"/cliente/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#email").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#inscricao").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Preencha obrigatórios!');
         }
    });
    // FIM das regras de gravação de clientes

     // Inicio das regras de gravação de Contatos
    jQuery("#form-contato").submit(function(e){
          e.preventDefault();
        var razao     = $("#razao").val();
        var tipo      = $("#tipo_id").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var site    = $("#site").val();
        var responsavel    = $("#responsavel").val();
        var endereco  = $("#endereco").val();
        var cidade  = $("#cidade").val();
        var cep       = $("#cep").val();
        var crea       = $("#crea").val();


        if (razao != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {razao:razao, fantasia:fantasia, tipo_id:tipo, cidade:cidade, crea:crea, email:email, documento:documento, inscricao:inscricao, telefone:telefone, site:site, responsavel:responsavel, endereco:endereco, cep:cep},
                url: urlbaseGeral+"/contato/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#email").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#inscricao").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Preencha os campos obrigatórios!');
         }
       
    });

    jQuery("#form-contato-edita").submit(function(e){
        e.preventDefault();
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var tipo      = $("#tipo_id").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var site    = $("#site").val();
        var responsavel    = $("#responsavel").val();
        var endereco  = $("#endereco").val();
         var cidade  = $("#cidade").val();
        var cep       = $("#cep").val();
        var crea       = $("#crea").val();
        var id       = $("#id").val();

       if (razao != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {id:id, razao:razao, cidade:cidade, crea:crea, fantasia:fantasia, email:email, tipo_id:tipo, documento:documento, inscricao:inscricao, telefone:telefone, site:site, responsavel:responsavel, endereco:endereco, cep:cep},
                url: urlbaseGeral+"/contato/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#email").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#inscricao").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Preencha os campos obrigatórios!');
         }
    });
    // FIM das regras de gravação de Contatos

    // Inicio das regras de gravação de Categorias de Contatos
    jQuery("#form-tipo").submit(function(e){
          e.preventDefault();
        var descricao     = $("#descricao").val();



        if ( descricao != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {descricao:descricao},
                url: urlbaseGeral+"/contato/tipo/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
       
    });

    jQuery("#form-tipo-edita").submit(function(e){
        e.preventDefault();
        var descricao     = $("#descricao").val();
        var id     = $("#id").val();

         if ( descricao != '') {
           $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {descricao:descricao, id:id},
                url: urlbaseGeral+"/contato/tipo/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
    });
    // FIM das regras de gravação de Categorias de Contatos

    // Inicio das regras de gravação de Tipos de Subetapas
    jQuery("#form-tipo-sub").submit(function(e){
          e.preventDefault();
        var descricao     = $("#descricao").val();



        if ( descricao != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {descricao:descricao},
                url: urlbaseGeral+"/subetapa/tipo/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
       
    });

    jQuery("#form-tipo-sub-edita").submit(function(e){
        e.preventDefault();
        var descricao     = $("#descricao").val();
        var id     = $("#id").val();

         if ( descricao != '') {
           $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {descricao:descricao, id:id},
                url: urlbaseGeral+"/subetapa/tipo/update",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');

                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
    });
    // FIM das regras de gravação de Tipos de Subetapas

    // Inicio das regras de gravação de parceiro
    jQuery("#form-parceiro").submit(function(e){
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var tipo      = $("#tipo").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var cidade    = $("#cidade").val();
        var endereco  = $("#endereco").val();
        var cep       = $("#cep").val();
        var outro     = $("#outro").val();

        if($("#construtora").is(":checked")) {
            var construtora = 1;
        } else {
            var construtora = 0;
        }
        if($("#gerenciadora").is(":checked")) {
            var gerenciadora = 1;
        } else {
            var gerenciadora = 0;
        }
        if($("#calculista").is(":checked")) {
            var calculista = 1;
        } else {
            var calculista = 0;
        }
        if($("#detalhamento").is(":checked")) {
            var detalhamento = 1;
        } else {
            var detalhamento = 0;
        }
        if($("#montagem").is(":checked")) {
            var montagem = 1;
        } else {
            var montagem = 0;
        }

        if ( razao != '' && fantasia != '' && email != '' && tipo != '' && documento != '' && inscricao != '' && telefone != '' && cidade != '' && endereco != '' && cep != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {razao:razao, fantasia:fantasia, email:email, tipo:tipo, documento:documento, inscricao:inscricao, telefone:telefone, cidade:cidade, endereco:endereco, cep:cep, construtora:construtora, gerenciadora:gerenciadora, calculista:calculista, detalhamento:detalhamento, montagem:montagem, outro:outro},
                url: Basepath + "/saas/parceiros/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#email").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#inscricao").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                        $("#outro").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-parceiro-edita").submit(function(e){
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var email     = $("#email").val();
        var tipo      = $("#tipo").val();
        var documento = $("#documento").val();
        var inscricao = $("#inscricao").val();
        var telefone  = $("#telefone").val();
        var cidade    = $("#cidade").val();
        var endereco  = $("#endereco").val();
        var cep       = $("#cep").val();
        var outro     = $("#outro").val();
        var clienteID = $("#clienteID").val();

        if($("#construtora").is(":checked")) {
            var construtora = 1;
        } else {
            var construtora = 0;
        }
        if($("#gerenciadora").is(":checked")) {
            var gerenciadora = 1;
        } else {
            var gerenciadora = 0;
        }
        if($("#calculista").is(":checked")) {
            var calculista = 1;
        } else {
            var calculista = 0;
        }
        if($("#detalhamento").is(":checked")) {
            var detalhamento = 1;
        } else {
            var detalhamento = 0;
        }
        if($("#montagem").is(":checked")) {
            var montagem = 1;
        } else {
            var montagem = 0;
        }
        if ( razao != '' && fantasia != '' && email != '' && tipo != '' && documento != '' && inscricao != '' && telefone != '' && cidade != '' && endereco != '' && cep != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {razao:razao, fantasia:fantasia, email:email, tipo:tipo, documento:documento, inscricao:inscricao, telefone:telefone, cidade:cidade, endereco:endereco, cep:cep, clienteID:clienteID, construtora:construtora, gerenciadora:gerenciadora, calculista:calculista, detalhamento:detalhamento, montagem:montagem, outro:outro},
                url: Basepath + "/saas/parceiros/gravarEdicao",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });
    // FIM das regras de gravação de clientes

    // INICIO das regras de gravação de locatários
    jQuery("#form-locatario").submit(function(e){
        var razao     = $("#razao").val();
        var fantasia  = $("#fantasia").val();
        var tipo      = $("#tipo").val();
        var documento = $("#documento").val();
        var telefone  = $("#telefone").val();
        var cidade    = $("#cidade").val();
        var inscricao = $("#inscricao").val();
        var endereco  = $("#endereco").val();
        var cep       = $("#cep").val();
        var email     = $("#email").val();

        if ( razao != '' && fantasia != '' && tipo != '' && documento != '' && telefone != '' && cidade != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {razao:razao, fantasia:fantasia, tipo:tipo, documento:documento, telefone:telefone, cidade:cidade, inscricao:inscricao, endereco:endereco, cep:cep, email:email},
                url: Basepath + "/sistema/locatarios/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                       $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#inscricao").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                        $("#email").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-locatario-edita").submit(function(e){
        var razao       = $("#razao").val();
        var fantasia    = $("#fantasia").val();
        var tipo        = $("#tipo").val();
        var documento   = $("#documento").val();
        var telefone    = $("#telefone").val();
        var cidade      = $("#cidade").val();
        var locatarioID = $("#locatarioID").val();
        var inscricao   = $("#inscricao").val();
        var endereco    = $("#endereco").val();
        var cep         = $("#cep").val();
        var email       = $("#email").val();

        if ( razao != '' && fantasia != '' && tipo != '' && documento != '' && telefone != '' && cidade != '' && locatarioID != '') {
            jQuery.ajax({
                type: "POST",
                data: {razao:razao, fantasia:fantasia, tipo:tipo, documento:documento, telefone:telefone, cidade:cidade, locatarioID:locatarioID, inscricao:inscricao, endereco:endereco, cep:cep, email:email},
                url: Basepath + "/sistema/locatarios/gravarEdicao",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#razao").val('');
                        $("#fantasia").val('');
                        $("#tipo").val('');
                        $("#documento").val('');
                        $("#telefone").val('');
                        $("#cidade").val('');
                        $("#locatarioID").val('');
                        $("#inscricao").val('');
                        $("#endereco").val('');
                        $("#cep").val('');
                        $("#email").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });
    // FIM das regras de gravação de locatários

    // INICIO das regras de gravação de usuários dos locatários
    jQuery("#form-locatariousuario").submit(function(e){
        var nome          = $("#nome").val();
        var email         = $("#email").val();
        var senha         = $("#senha").val();
        var locatarioID   = $("#locatarioID").val();
        var tipoUsuarioID = $("#tipoUsuarioID").val();

        if ( nome != '' && email != '' && senha != '' && locatarioID != '' && tipoUsuarioID != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {nome:nome, email:email, senha:senha, locatarioID:locatarioID, tipoUsuarioID:tipoUsuarioID},
                url: Basepath + "/sistema/locatariosUsuarios/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#nome").val('');
                        $("#email").val('');
                        $("#senha").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-locatariousuario-edita").submit(function(e){
        var nome               = $("#nome").val();
        var email              = $("#email").val();
        var senha              = $("#senha").val();
        var locatarioID        = $("#locatarioID").val();
        var usuarioLocatarioID = $("#usuarioLocatarioID").val();
        var tipoUsuarioID      = $("#tipoUsuarioID").val();

        if ( nome != '' && email != '' && senha != '' && locatarioID != '' && usuarioLocatarioID != '' && tipoUsuarioID != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {nome:nome, email:email, senha:senha, locatarioID:locatarioID, usuarioLocatarioID:usuarioLocatarioID, tipoUsuarioID:tipoUsuarioID},
                url: Basepath + "/sistema/locatariosUsuarios/gravarEdicao",
                dataType: "html",
                success: function(result){
                   if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#nome").val('');
                        $("#email").val('');
                        $("#senha").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });
    // FIM das regras de gravação de usuários de locatários

    // Inicio das regras de gravação de usuários do saas
    jQuery("#form-admin").submit(function(e){
        var nome          = $("#nome").val();
        var email         = $("#email").val();
        var senha         = $("#senha").val();

        if ( nome != '' && email != '' && senha != '') {
            $('#tipoError2').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoLoading').removeClass('hidden');
            jQuery.ajax({
                type: "POST",
                data: {nome:nome, email:email, senha:senha},
                url: Basepath + "/sistema/usuarios/gravar",
                dataType: "html",
                success: function(result){
                    if (result.substring(0,7) == 'sucesso') {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoSuccess').removeClass('hidden');
                        $('#tipoError').addClass('hidden');
                        $('#tipoError2').addClass('hidden');
                        $("#nome").val('');
                        $("#email").val('');
                        $("#senha").val('');
                    } else {
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError2').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    }
                },
                error: function(result){
                    $('#tipoLoading').addClass('hidden');
                    $('#tipoError').removeClass('hidden');
                    $('#tipoSuccess').addClass('hidden');
                },
            });
         } else {
            alert('Todos os campos são obrigatórios!');
         }
         e.preventDefault();
    });

    jQuery("#form-admin-edita").submit(function(e){
            var nome          = $("#nome").val();
            var email         = $("#email").val();
            var senha         = $("#senha").val();
            var usuarioAdminID = $("#usuarioAdminID").val();

            if ( nome != '' && email != '' && senha != '' && usuarioAdminID != '') {
                jQuery.ajax({
                    type: "POST",
                    data: {nome:nome, email:email, senha:senha, usuarioAdminID:usuarioAdminID},
                    url: Basepath + "/sistema/usuarios/gravarEdicao",
                    dataType: "html",
                    success: function(result){
                        if (result.substring(0,7) == 'sucesso') {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoSuccess').removeClass('hidden');
                            $('#tipoError').addClass('hidden');
                            $('#tipoError2').addClass('hidden');
                        } else {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoError2').removeClass('hidden');
                            $('#tipoSuccess').addClass('hidden');
                        }
                    },
                    error: function(result){
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    },
                });
             } else {
                alert('Todos os campos são obrigatórios!');
             }
             e.preventDefault();
        });

 jQuery("#profileEdit").submit(function(e){
            var nome          = $("#nome").val();
            var email         = $("#email").val();
            var role          = $("#roleID").val();
            var userID        = $("#userID").val(); 

            if ( nome != '' && email != '' && role != '' && userID != '') {
                $('#tipoError2').addClass('hidden');
                $('#tipoError').addClass('hidden');
                $('#tipoSuccess').addClass('hidden');
                $('#tipoLoading').removeClass('hidden');
                jQuery.ajax({
                    type: "POST",
                    data: {nome:nome, email:email, role:role, userID:userID},
                    url: Basepath + "/sistema/usuarios/userEdicao",
                    dataType: "html",
                    success: function(result){
                        if (result.substring(0,7) == 'sucesso') {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoSuccess').removeClass('hidden');
                            $('#tipoError').addClass('hidden');
                            $('#tipoError2').addClass('hidden');
                        } else {
                            $('#tipoLoading').addClass('hidden');
                            $('#tipoError2').removeClass('hidden');
                            $('#tipoSuccess').addClass('hidden');
                        }
                    },
                    error: function(result){
                        $('#tipoLoading').addClass('hidden');
                        $('#tipoError').removeClass('hidden');
                        $('#tipoSuccess').addClass('hidden');
                    },
                });
             } else {
                alert('Todos os campos são obrigatórios!');
             } 
             e.preventDefault();
        });
    //Fim das regras de gravação de usuários SAAS

    if($("#needToConvert").length ) {
        var id          = $("#needToConvert").html();
     //   var done = 0;

        $.ajax({
          url: Basepath + "/saas/importacoes/getIfc",
          type: "POST",
          data: {id: id},
          cache: false,
          success: function(e){
            location.reload();
          }
        });
    }
        

    var FoneMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    foneOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(FoneMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.telefone').mask(FoneMaskBehavior, foneOptions);

    $('.closeIt').click(function(event) {
         $('#tipoError3').addClass('hidden');
        $('#tipoError2').addClass('hidden');
        $('#tipoError').addClass('hidden');
        $('#tipoSuccess').addClass('hidden');
    });

    // var options = {
    //     onKeyPress: function(documento, e, field, options){
    //         var masks = ['000.000.000-00', '00.000.000/0000-00'];
    //         var teste = (documento.length > 20) ? masks[1] : masks[0];
    //         console.log(teste);
    //         $('.documento').mask(teste, options);
    //     }
    // };

    // $('.documento').mask('00.000.000/0000-00', docOptions);
    // $('.documento').mask('00.000.000/0000-00', options);
    $('.cep').mask('00000-000');

    $('#subImport').click(function() {
        $('#tipoLoading').removeClass('hidden');
    });


    $('#xsuccess').click(function() {
        $('#convertSuccess').fadeOut('fast');
    });

    $('#xerro').click(function() {
        $('#convertError').fadeOut('fast');
    });

    $('.delEtapa').click(function(e) {
        e.preventDefault();
        $('#tipoError3').addClass('hidden');
        $('#tipoError2').addClass('hidden');
        $('#tipoError').addClass('hidden');
        $('#tipoSuccess').addClass('hidden');
        $('#tipoLoading').removeClass('hidden');
        var idEtapa          = $(this).attr('name');
        $.ajax({
          url: urlbaseGeral+"/etapa/excluir",
          type: "POST",
          data: {id: idEtapa},
          dataType: "html",
          success: function(result){
           if (result.substring(0,7) == 'sucesso') {
            location.reload();
        } else {
            $('#tipoError3').addClass('hidden');
            $('#tipoError2').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError').removeClass('hidden');
            $('#tipoSuccess').addClass('hidden');
        }
          },
        error: function(result){
            $('#tipoError3').addClass('hidden');
            $('#tipoError2').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError').removeClass('hidden');
            $('#tipoSuccess').addClass('hidden');
        }
        });
    });

    $('.delSubEtapa').click(function(e) {
        e.preventDefault();
        $('#tipoError3').addClass('hidden');
        $('#tipoError2').addClass('hidden');
        $('#tipoError').addClass('hidden');
        $('#tipoSuccess').addClass('hidden');
        $('#tipoLoading').removeClass('hidden');
        var idEtapa          = $(this).attr('name');
        $.ajax({
          url: urlbaseGeral+"/subetapa/excluir",
          type: "POST",
          data: {id: idEtapa},
          dataType: "html",
          success: function(result){
           if (result.substring(0,7) == 'sucesso') {
            location.reload();
        }
        else if(result.substring(0,7) == 'erro2') {
            $('#tipoError3').addClass('hidden');
            $('#tipoError').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError2').removeClass('hidden');
            $('#tipoSuccess').addClass('hidden');
        }else if(result.substring(0,7) == 'erro3'){
            $('#tipoError').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError2').addClass('hidden');
            $('#tipoSuccess').addClass('hidden');
            $('#tipoError3').removeClass('hidden');
        }
        else{
            $('#tipoError3').addClass('hidden');
            $('#tipoError2').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError').removeClass('hidden');
            $('#tipoSuccess').addClass('hidden');
        }
          },
        error: function(result){
            $('#tipoError3').addClass('hidden');
            $('#tipoError2').addClass('hidden');
            $('#tipoLoading').addClass('hidden');
            $('#tipoError').removeClass('hidden');
            $('#tipoSuccess').addClass('hidden');
        }
        });
    });
    var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})
});