(function($, global) {
    var ncfData = global.ncforms_data;

    $(function() {
        var id = ncfData.id || null,
            prefix = ncfData.prefix;

        // Create form builder.
        var builder = nocake.form.builder.create({
            el: '#ncforms-form-builder',
            value: ncfData.value || null,
            // Wordpress top bar have 99999.
            previewZIndex: 100000,
            themes: {
                ncfbdef: { name: 'Default', url: ncfData.pluginUrl + '/form-builder/assets/themes/default.css' },
                ncfbmodern: { name: 'Modern', url: ncfData.pluginUrl + '/form-builder/assets/themes/modern.css' },
                ncfbmonokai: { name: 'Monokai', url: ncfData.pluginUrl + '/form-builder/assets/themes/monokai.css' },
                ncfbwombat: { name: 'Wombat', url: ncfData.pluginUrl + '/form-builder/assets/themes/wombat.css' },
                ncfbzenburn: { name: 'Zenburn', url: ncfData.pluginUrl + '/form-builder/assets/themes/zenburn.css' },
            },
            onPreviewSubmit(form) {
                // Save builders form first, then submit preview form.
                saveReq().then(function() {
                    var obj = {}
                    obj[prefix + '_action'] = 'submit'
                    obj[prefix + '_form'] = form.form.uuid
                    form.send(obj)
                })
            },
            formHandlerUrl: ncfData.siteUrl
        })

        global.ncforms_builder = builder

        var save = _.debounce(function() {
            saveReq()
        }, 500)

        builder.on('change', save)

        var saveReq = function() {
            return $.ajax({
                url: ncfData.restUrl + 'ncforms/v1/form/save',
                method: 'POST',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader( 'X-WP-Nonce', ncfData.nonce);
                },
                data: {
                    id: id,
                    form: JSON.stringify(builder.getValue())
                },
                success(data) {
                    id = data.id
                },
                error() {
                    console.log('error')
                }
            })
        }

        // Remove form and redirect to list.
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
                        window.location = $this.data('redirect-url');
                    }
                })
            }
        })
    })
})(jQuery, window)
