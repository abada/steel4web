$(document).ready(function() {

  $('.closePanel').click(function(e) {
    e.preventDefault();
    $(this).parent('.panel-heading').parent('.panel').fadeOut('fast');
  });

  $('#dataTables').DataTable({
        responsive: true
    });


$('#noSort').DataTable({
        responsive: true,
        "ordering": false,
        "bInfo" : false
    });

//$('.toBeHidden').hide();

var toBe2 = 0;

$('#subToggle').click(function(e) {
   if(toBe2%2 != 0){
    $('.toBeHidden').show();
    $('.clickTable').removeClass('fa-plus').addClass('fa-minus');
  }else{
    $('.toBeHidden').hide();
    $('.clickTable').removeClass('fa-minus').addClass('fa-plus');
  }
  toBe2++;
});


   $('.clickTable').click(function(e) {
      var id = event.target.id;
      $('.'+id).toggle();
      $(this).toggleClass('fa-minus fa-plus');
   });

  

    var table = $('#lotPointer').DataTable();
 
    $('#formButton').click( function() {
        var data = table.$('input, select').serialize();
         jQuery.ajax({
                type: "POST",
                data: {dados:data},
               url: "http://localhost/new_s4w/saas/estagio/teste",
                dataType: "html",
                success: function(e){
                    $('#herehtml').html(result);
                }
            });
        return false;
    } );

 //  $.fn.editable.defaults.mode = 'inline';

            $('.username').editable({
           url: 'http://localhost/new_s4w/saas/estagio/teste',
           type: 'html',
            mode: 'inline',
           pk: 1,
           title: 'Enter username',
           success: function(result){
           	alert(result);
           	var myArray = result.split('&');
           	for (var i = 0; i < myArray.length; ++i) {
           			
           	
           $('#inputEtapa').append($('<option>', {
			    value: 1,
			    text: myArray[i]
			}));
           };
        }
    });

      $('.dob').editable({
      	 url: 'http://localhost/new_s4w/saas/estagio/teste',
           type: 'html',
           name: 'data',
        format: 'YYYY-MM-DD',    
        viewformat: 'DD.MM.YYYY',    
        template: 'D / MMMM / YYYY',    
        combodate: {
                minYear: 2000,
                maxYear: 2016,
                minuteStep: 1
        },
        success: function(d){
                    $('#herehtml').html(result);
                }
    });

      $('#inputChooseObra').change(function() {
      	$('.TypeLoading').removeClass('hidden');

      	var dados = $('#inputChooseObra').val();
     	jQuery.ajax({
                type: "POST",
                data: {id:dados},
               url: "/importador/etapas",
                dataType: "html",
                success: function(result){
             var myArray = result.split('&x&');
             var temp;
             $('#inputEtapa').find('option').remove().end();
             $('#inputEtapa').append($('<option>', {
          value: 0,
          text: 'Escolha uma Etapa...'
      }));
           	for (var i = 0; i < myArray.length; ++i) {
           		temp = myArray[i].split('&');
           $('#inputEtapa').append($('<option>', {
			    value: temp[0],
			    text: temp[1]
			}));
           temp = null;
           };
                }
            });
        $('.inputetapa').removeClass('hidden');
        $('.TypeLoading').addClass('hidden'); 
      });

       $('#inputEtapa').change(function() {
        $('.TypeLoading').removeClass('hidden');
        var dadoos = $('#inputEtapa').val();
      jQuery.ajax({
                type: "POST",
                data: {id:dadoos},
               url: "/importador/subetapas",
                dataType: "html",
                success: function(result2){
             var myArrayy = result2.split('&x&');
             var temp;
             $('#inputsubetapa').find('option').remove().end();
             $('#inputsubetapa').append($('<option>', {
          value: 0,
          text: 'Escolha uma Subetapa...'
      }));
            for (var i = 0; i < myArrayy.length; ++i) {
              temp = myArrayy[i].split('&');
           $('#inputsubetapa').append($('<option>', {
          value: temp[0],
          text: temp[1]
      }));
           temp = null;
           };
                }
            });
        $('.inputsubetapa').removeClass('hidden');
        $('.TypeLoading').addClass('hidden'); 
      });

       $('#inputsubetapa').change(function() {
         $('#inputSubmit').removeClass('hidden');
           var sube = $('#inputsubetapa').val();
           jQuery.ajax({
                type: "POST",
                data: {id:sube},
               url: "/importador/importar",
                dataType: "html",
                success: function(r){
                  var subed = JSON.parse(r);
                  $('#toReceiveSubId').val(subed.subetapa_id);
                }
            });
       });

         $('#importTable').DataTable({
              responsive: true
          });


    
} );