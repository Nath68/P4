var dateAuj = new Date();

var todayDisable = '';
/*if (heure >= 18) {
    todayDisable = dateAuj;var heure = dateAuj.getHours();
}*/



$('.calendar').datepicker({
    format: "dd-mm-yyyy",
    startDate: dateAuj,
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
    dateChoisie = new Date(dateChoisie);
    //dateChoisie = dateChoisie.setDate(dateChoisie.getDate()+1);
    if (dateChoisie == dateAuj) {
        alert('Test');
    }
    console.log(dateChoisie);
    console.log(dateAuj);
    $('#ml_billetteriebundle_commandes_duree').prop('checked', 'true');
});
