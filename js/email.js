$("#email").on('input', function(e){
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (regex.test($('#email').val()))
    {
        $('#email-valid').html("✔");
        $('#email-valid').css('color', 'green');
        $('input[type="submit"]').removeAttr('disabled');
    }
    else
    {
        $('#email-valid').html("✘");
        $('#email-valid').css('color', 'red');
        $('input[type="submit"]').attr('disabled', 'disabled');
    }
});