(function($, global) {
    var ncfData = global.ncforms_data;

    $(function() {
        $('body').on('click', '.js-ncforms-delete-submission', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this submission?')) {
                var $this = $(this);
                $.ajax({
                    url: ncfData.ajaxUrl,
                    data: {
                        action: 'ncforms_delete_submission',
                        id: $this.data('id'),
                        nonce: $this.data('nonce')
                    },
                    complete() {
                        window.location.reload();
                    }
                })
            }
        })

        $('.js-ncforms-submissions-select-form').on('change', function(e) {
            e.preventDefault();

            window.location = $(this).val()
        });
    })

})(jQuery, window)
