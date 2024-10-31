const { SelectControl } = wp.components
const $ = jQuery
const ncfData = global.ncforms_data;

wp.blocks.registerBlockType('ncforms/form', {
    title: 'NoCake Form',
    icon: 'lightbulb',
    category: 'common',
    attributes: {
        form_uid: {
            type: "string"
        }
    },
    edit: class extends wp.element.Component {
        constructor(props) {
            super(...arguments)
            const me = this
            this.state = {
                forms: [
                    { label: 'None', value: null }
                ]
            }
            $.ajax({
                url: ncfData.ajaxUrl,
                data: {
                    action: 'ncforms_forms'
                },
                success(data) {
                    const
                        items = data.data,
                        options = [{ label: 'None', value: null }]
                    for (let key in items) {
                        options.push({ label: items[key].name, value: items[key].uid })
                    }
                    me.setState({ forms: options })
                }
            })
        }
        iframeLoaded() {
            const
                iframe = this.refs.iframe,
                height = iframe.contentWindow.document.body.scrollHeight + 60
            iframe.style.height =
            iframe.parentNode.style.height =
            iframe.parentNode.parentNode.parentNode.parentNode.style.height = height + 'px'
            // Select block when clicking inside iframe.
            $(iframe.contentWindow.document.body).on('click', () => {
                const { selectBlock } = wp.data.dispatch('core/block-editor')
                selectBlock(this.props.clientId)
            })
        }
        render() {
            const
                formUid = this.props.attributes.form_uid,
                prefix = ncfData.prefix,
                iframeUrl = ncfData.siteUrl + '?' + prefix + '_action=form&'+prefix+'_form='+formUid+'&_ncforms_preview=1'
            return (
                <div>
                    <div class="ncforms-form-select">
                        <label style={{ paddingRight: '10px', fontSize: '14px', fontFamily: 'Arial', display: 'inline-block' }}>Selected Form: </label>
                        <div style={{ display: 'inline-block', verticalAlign: 'middle', marginBottom: '-8px' }}>
                            <SelectControl
                                label=""
                                value={this.props.attributes.form_uid}
                                options={this.state.forms}
                                onChange={(value) => this.props.setAttributes({ form_uid: value })}
                            />
                        </div>
                    </div>
                    {
                        this.props.attributes.form_uid &&
                        <div>
                            <iframe src={iframeUrl} ref="iframe" style={{border: '0px', width: '100%'}} onLoad={()=>this.iframeLoaded()}></iframe>
                        </div>
                    }
                </div>
            )
        }
    },
    save() {
        return null
    }
})
