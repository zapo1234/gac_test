$(document).ready(function(){
// recupérer les dates entrées
$('#envoyer').click(function(){
var date_start= $('#date_sart').val();
var date_end = $('#date_end').val();

if(date_start.length !="" && date_end.length !="") {
    $.ajax({
    type: 'POST', // on envoi les donnes
    url:  '/rechers',// on traite par la fichier
    data : {date_start:date_start, date_end:date_end},
    success:function(data) { // on traite le fichier recherche apres le retour
    $('#resultats').html(data);
    }

    });
     }
    });
 });
