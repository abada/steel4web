$(document).ready(function() {

	// Bootstrap Select
	$('.selectpicker').selectpicker({		
		size: 4
	});

    /*
        MODAL RELOAD
    */
    var modalscripts = function() {

        // Remove the data-toggle attribute inside the modals to prevent modals close
        $.each($(".modal [data-target=#modal]"), function(index, val) {
            $(this).removeAttr('data-toggle');
        });

        // Inside the modals, if another modal is called, so open the respective content via AJAX in the same modal opened
        $(".modal [data-target=#modal]").click(function(ev) {

            ev.preventDefault();
            $("#modal .modal-dialog .modal-content").html('<p class="text-center well-lg">' + '<div class="loading"></div>' + '</p>');

            var target = $(this).attr("href");

            $("#modal .modal-dialog .modal-content").load(target, function() {
                $("#modal").modal("show");
            }).error(function(data) {
                $("#modal").find('.modal-content').html(data).modal("show");
            });;

        });

    };

    //LIMPA MODALS
    $('body').on('hidden.bs.modal', '#modal', function() {
        $(this).removeData('bs.modal');
        $(this).find('.modal-content').html('<div class="text-center well-lg">' + '<div class="loading"></div>' + '</div>');
    });

    $('body').on('show.bs.modal', '#modal', function(event) {
        $(this).find('.modal-content').html('<div class="text-center well-lg">' + '<div class="loading"></div>' + '</div>');
    });

    $('body').on('loaded.bs.modal', '#modal', function() {        
        modalscripts();
    });

/* Volta para a Tab sendo visualizada em um refresh/redirectBack */
    var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
} 

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})

/* Adiciona Token no Header de cada ajax*/
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
	
});