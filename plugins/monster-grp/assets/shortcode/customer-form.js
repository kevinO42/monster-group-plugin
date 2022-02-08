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
                if (response) {
                    // show alert message
                    $('#response-message').show();
                    $('#response-message').append('<span class="message">Thank you! We will be in contact shortly.</span>');

                    // removes alert message after 3 seconds
                    setTimeout(function() { 
                        $('#response-message').hide();
                    }, 3000);

                    // clear form
                    $('#monster-customer-form')[0].reset();
                }
               
            }
        })
    })
})(jQuery)