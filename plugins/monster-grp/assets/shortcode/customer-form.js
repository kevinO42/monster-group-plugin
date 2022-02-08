(function($) { 
    $('#monster-customer-form').submit(function(event) {
        event.preventDefault();
        
        var form = $(this).serialize();

        $.ajax({
            method: 'post',
            url: params.url,
            headers: { 'X-WP-Nonce': params.nonce },
            data: form,
            dataType: 'json',
            success: function (response) {
                //show alert message
                $('#response-message').show();

                if (response.status) {
                    // add success message
                    $('#response-message').append('<span class="response-success-message">Thank you! We will be in contact shortly.</span>');

                    // removes alert message after 3 seconds
                    setTimeout(function() {
                        $('#response-message').html('').append('');
                        $('#response-message').hide();
                    }, 3000);

                    // clear form
                    $('#monster-customer-form')[0].reset();

                }

                if (!response.status) {
                    // add error message
                    $('#response-message').append('<ul class="response-error-message">');
                    $.each(response.errors, function(index, value) {
                        $("#response-message ul").append("<li>" + value + "</li>");
                      });

                    // removes list alert message
                    setTimeout(function() { 
                        $('#response-message').html('').append('');
                        $('#response-message').hide();
                    }, 3000);
                }
            }
        })
    })
})(jQuery)