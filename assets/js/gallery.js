
// pour les images de la galerie, 
$(function() {
    $('.wrapper').click(function() {
        $('.wrapper').each(function() {
            $(this).css('z-index', 0); 
        });
        //au click sur l'image on fait passer l'image en premier plan
        $(this).css('z-index', 10); 
        $(this).toggleClass('open');

        //Modal de suppression d'image
        $(".confirmDeleteMedia").click(function (e) {
            e.preventDefault();
            theHREF = $(this).attr("href");
            $("#confirmDeleteModalMedia").modal("show");
        });

        $("#confirmDeleteMediaYes").click(function (e) {
            window.location.href = theHREF;
        });   
    }) 
})
