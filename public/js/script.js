$(document).ready(function($) {

    // STICKYTABS
    $('.nav.nav-tabs').stickyTabs();

    var modalscripts = function() {

        /*
            MODAL RELOAD    
        */
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

        //Bootstrap WYSIHTML5 - text editor
        $(".modal textarea.wysihtml5").wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": false, //Button to change color of font  
            "blockquote": true, //Blockquote  
            "size": 'xs' //default: none, other options are xs, sm, lg
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

    //Bootstrap WYSIHTML5 - text editor
    $("textarea.wysihtml5").wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": true, //Button to insert a link. Default true
        "image": true, //Button to insert an image. Default true,
        "color": false, //Button to change color of font  
        "blockquote": true, //Blockquote  
        "size": 'xs' //default: none, other options are xs, sm, lg
    });


    
});


/**
 * jQuery Plugin: Sticky Tabs
 *
 * @author Aidan Lister <aidan@php.net>
 * @version 1.2.0
 */
(function($) {
    $.fn.stickyTabs = function(options) {
        var context = this

        var settings = $.extend({
            getHashCallback: function(hash, btn) {
                return hash
            }
        }, options);

        // Show the tab corresponding with the hash in the URL, or the first tab.
        var showTabFromHash = function() {
            var hash = window.location.hash;
            var selector = hash ? 'a[href="' + hash + '"]' : 'li.active > a';
            $(selector, context).tab('show');
        }

        // We use pushState if it's available so the page won't jump, otherwise a shim.
        var changeHash = function(hash) {
            if (history && history.pushState) {
                history.pushState(null, null, '#' + hash);
            } else {
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;
                window.location.hash = hash;
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }

        // Set the correct tab when the page loads
        showTabFromHash(context)

        // Set the correct tab when a user uses their back/forward button
        $(window).on('hashchange', showTabFromHash);

        // Change the URL when tabs are clicked
        $('a', context).on('click', function(e) {
            var hash = this.href.split('#')[1];
            var adjustedhash = settings.getHashCallback(hash, this);
            changeHash(adjustedhash);
        });

        return this;
    };
}(jQuery));