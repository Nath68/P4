var dateAuj = new Date();
startDate = dateAuj;
var heure = dateAuj.getHours();
var dateFormatAuj = (dateAuj.getMonth()+1)+'/'+dateAuj.getDate()+'/'+dateAuj.getFullYear();
dateAuj = dateFormatAuj;
var todayDisable = '';

$('.calendar').datepicker({
    format: "dd-mm-yyyy",
    startDate: startDate,
    keyboardNavigation: false,
    autoclose: true,
    maxViewMode: 2,
    todayBtn: true,
    language: "fr",
    daysOfWeekDisabled: "0,2",
    calendarWeeks: true,
    todayHighlight: true,
    datesDisabled: [todayDisable]
});

$('.calendar').change(function (){
    var dateChoisie = $('.calendar').val();
    var dateFormat = dateChoisie.split('-');
    dateChoisie = dateFormat[1]+'/'+dateFormat[0]+'/'+dateFormat[2];
    console.log(dateChoisie);
    console.log(dateAuj);
    console.log(heure);

    if (dateChoisie == dateAuj && heure >= 14) {
        alert('Il est plus de 14h, seule la commande de demi-journée est disponible.');
        $('#ml_billetteriebundle_commandes_duree').prop('checked', true).attr('disabled', true);
    }
    else {
        $('#ml_billetteriebundle_commandes_duree').prop('checked', false).removeAttr('disabled');
    }

});
