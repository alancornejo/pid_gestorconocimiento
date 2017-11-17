//Start navbar toggle fix top bottom
$(document).on('click', '.toggle_fixing', function(e) {
    e.preventDefault();
    if ($('#main_navbar').hasClass('navbar-fixed-top')) {
        $('#main_navbar').toggleClass('navbar-fixed-bottom navbar-fixed-top');
        $(this).children('i').toggleClass('fa-chevron-down fa-chevron-up');
    } else {
        $('#main_navbar').toggleClass('navbar-fixed-bottom');
        $(this).children('i').toggleClass('fa-chevron-down fa-chevron-up');
        if ($('#main_navbar').parent('div').hasClass('container')) $('#main_navbar').children('div').addClass('container').removeClass('container-fluid');
        else if ($('#main_navbar').parent('div').hasClass('container-fluid')) $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
        FixMegaNavbar(navHeight);
    }
    if ($('#main_navbar').hasClass('navbar-fixed-top')) {$('body').css({'margin-top': $('#main_navbar').height()+'px', 'margin-bottom': ''});}
    else if ($('#main_navbar').hasClass('navbar-fixed-bottom')) {$('body').css({'margin-bottom': $('#main_navbar').height()+'px', 'margin-top': ''});}
})
//End navbar toggle fix top bottom

//Start Fix MegaNavbar on scroll page
var navHeight = $('#main_navbar').offset().top;
FixMegaNavbar(navHeight);
$(window).bind('scroll', function() {FixMegaNavbar(navHeight);});

function FixMegaNavbar(navHeight) {
    if (!$('#main_navbar').hasClass('navbar-fixed-bottom')) {
        if ($(window).scrollTop() > navHeight) {
            $('#main_navbar').addClass('navbar-fixed-top')
            $('body').css({'margin-top': $('#main_navbar').height()+'px'});
            if ($('#main_navbar').parent('div').hasClass('container')) $('#main_navbar').children('div').addClass('container').removeClass('container-fluid');
            else if ($('#main_navbar').parent('div').hasClass('container-fluid')) $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
        }
        else {
            $('#main_navbar').removeClass('navbar-fixed-top');
            $('#main_navbar').children('div').addClass('container-fluid').removeClass('container');
            $('body').css({'margin-top': ''});
        }
    }
}
//End Fix MegaNavbar on scroll page

//Next code used to prevent unexpected menu close when using some components (like accordion, tabs, forms, etc), please add the next JavaScript to your page
$( window ).load(function() {
    $(document).on('click', '.navbar .dropdown-menu', function(e) {e.stopPropagation();});
});

function digiClock (){
    var crTime = new Date ( );  
    var crHrs = crTime.getHours ( );  
    var crMns = crTime.getMinutes ( );  
    var crScs = crTime.getSeconds ( );  
    crMns = ( crMns < 10 ? "0" : "" ) + crMns;  
    crScs = ( crScs < 10 ? "0" : "" ) + crScs;  
    var timeOfDay = ( crHrs < 12 ) ? "AM" : "PM";  
    crHrs = ( crHrs > 12 ) ? crHrs - 12 : crHrs;  
    crHrs = ( crHrs == 0 ) ? 12 : crHrs;  
    var crTimeString = crHrs + ":" + crMns + ":" + crScs + " " + timeOfDay;  
  
    $("#clock").html(crTimeString);
}

$('.sub_opciones_plataforma').fadeOut('fast');

$('div.opciones_plataforma').mouseenter(function(){
    var id = $(this).data('id');
    $('div.ef_'+id).addClass('efecto_opciones_plataforma');
});

$('div.opciones_plataforma').mouseleave(function(){
    var id = $(this).data('id');
    $('div.ef_'+id).removeClass('efecto_opciones_plataforma');
});

$('div.opciones_plataforma').click(function(){
    var id = $(this).data('id');
    $('.panel_opciones_plataforma').fadeOut('fast',function(){
        $('li#'+id).fadeIn('fast');
    });
});

$('a.regresar_opciones_plataforma').click(function(){
    var id = $(this).data('id');
    $('.sub_opc_'+id).fadeOut('fast',function(){
        $('li#todos_paneles').fadeIn('fast');
    });
});