var dateAuj = new Date();
startDate = dateAuj;
var heure = dateAuj.getHours();
var dateFormatAuj = (("0" + (dateAuj.getMonth() + 1)).slice(-2))+'/'+("0" + dateAuj.getDate()).slice(-2)+'/'+dateAuj.getFullYear();
dateAuj = dateFormatAuj;

if (heure >= 18) {
    var todayDisable = dateAuj;
}


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
    datesDisabled: [todayDisable, '01/05/2017', '01/11/2017', '25/12/2017', '01/05/2018', '01/11/2018', '25/12/2018', '01/05/2019', '01/11/2019', '25/12/2019']
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
