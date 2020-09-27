$(function(){
    $(".navbar a, footer a").on("click", function(event){
        event.preventDefault();
        var hash = this.hash;
        $('body, html').animate({scrollTop: $(hash).offset().top}, 100, function(){window.location.hash = hash})
    });

    $('#contact-form').submit(function(e){
        e.preventDefault();  //Enlever le comportement par défaut lorsqu'on soumet le formulaire.
        $('.comments').empty();  //Vider les commentaires à chaque fois.
        var postdata = $('#contact-form').serialize();

        $.ajax({
            type: 'POST',
            url: 'php/contact.php',
            data: postdata,
            dataType: 'json',
            success: function(result){

                if (result.isSuccess) {
                    $("#contact-form").append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                    $("#contact-form")[0].reset();  //Reset de tous les éléments qui se trouvent dans contact-form
                }
                else{
                    $("#firstname + .comments").html(result.firstnameError);
                    $("#name + .comments").html(result.nameError);
                    $("#email + .comments").html(result.emailError);
                    $("#phone + .comments").html(result.phoneError);
                    $("#message + .comments").html(result.messageError);
                }

            }
        });
    });
});
