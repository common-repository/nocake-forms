(function($, global) {
    $(function() {
        let ncfData = global.ncforms_data,
            body = $('body'),
            btnOpen = $('.js-ncforms-contact-us-open'),
            modal = $('.js-ncforms-contact-us-modal');

        // Open modal.
        body.on('click', '.js-ncforms-contact-us-open', function(e) {
           e.preventDefault();

           modal.fadeIn();
        });

        // Close modal.
        body.on('click', '.js-ncforms-contact-us-close', function(e) {
            e.preventDefault();

            modal.fadeOut();
        });

        // Close by click outside modal.
        body.on('click', function(e) {
            let target = $(e.target);

            if (
                !btnOpen.is(e.target) &&
                target.parent('.js-ncforms-contact-us-open').length !== 1 &&
                !modal.is(e.target) &&
                target.closest('.js-ncforms-contact-us-modal').length !== 1
            ) {
                modal.fadeOut();
            }
        });

        // Send form.
        body.on('submit', '.js-ncforms-contact-form', function(e) {
            e.preventDefault();

            let form = $(this),
                type = $('.ncforms-contact--input[name="type"]'),
                email = $('.ncforms-contact--input[name="email"]'),
                message = $('.ncforms-contact--input[name="message"]'),
                emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            // Remove old errors.
            $('.ncforms-contact-error').remove();

            // Validate email.
            if (!emailRegex.test(email.val())) {
                email.parent().append('<span class="ncforms-contact-error">Email address cannot be empty.</span>');
                return;
            }
            if (!emailRegex.test(email.val())) {
                email.parent().append('<span class="ncforms-contact-error">This is not correct email address.</span>');
                return;
            }

            // Validate message.
            if (message.val().length === 0) {
                message.parent().append('<span class="ncforms-contact-error">The message cannot be empty.</span>');
                return;
            }

            let data = {
                action: 'ncforms_contact_form',
                type: type.val(),
                email: email.val(),
                message: message.val()
            }

            // Attach form.
            if ($('#ncforms-contact-attach-form').is(':checked')) {
                data.data = JSON.stringify(global.ncforms_builder.getValue());
            }

            // Send message.
            $.ajax({
                url: ncfData.ajaxUrl,
                method: 'POST',
                data: data,
                success() {
                    // Show message and hide modal after 3 seconds.
                    form.fadeOut(() => {
                        modal.append('<span class="ncforms-contact-message-success">Thanks for sending us your feedback.</span>');

                        setTimeout(() => {
                            modal.fadeOut();
                        }, 2000);
                    });
                },
                error(e) {
                    // Show error message.
                    form.fadeOut(() => {
                        modal.append('<span class="ncforms-contact-message-error">'+e.responseJSON.data.error+'</span>');
                    });
                }
            });

            return false;
        })
    })

})(jQuery, window)
