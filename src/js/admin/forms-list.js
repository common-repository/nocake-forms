(function($, global) {
    var ncfData = global.ncforms_data;

    $(function() {
        $('body').on('click', '.js-ncforms-delete-form', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this form?')) {
                var $this = $(this);
                $.ajax({
                    url: ncfData.ajaxUrl,
                    data: {
                        action: 'ncforms_delete_form',
                        id: $this.data('id'),
                        nonce: $this.data('nonce')
                    },
                    complete() {
                        window.location.reload();
                    }
                })
            }
        })
    })

})(jQuery, window)
