"use strict";

(function ($, alert, bs) {
    const mainContent = $('#mainContent')

    const load = (url, callback) => {
        if (url) mainContent.load(url, (res, status, xhr) => {
            if (status === 'error') {
                console.error(xhr.status, xhr.statusText)
            } else {
                runAnchorWithAjax()
                checkboxFormSubmit()
                checkUncheck()
                dataGridPreview()
            }
        })
    }

    const runAnchorWithAjax = () => {
        $('a:not(.notAJAX)').on('click', e => {
            e.preventDefault()
            load($(e.currentTarget).attr('href'))

            if ($(e.currentTarget).hasClass('subMenuItem')) {
                $('.subMenuItem').removeClass('curModuleLink')
                $(e.currentTarget).addClass('curModuleLink')
            }
        })
    }

    const checkboxFormSubmit = () => {
        $('.checkboxFormSubmit').on('click', e => {
            e.preventDefault()
            let target = $(e.currentTarget)
            let tableName = target.data('table-name')
            let message = target.data('message')

            alert.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    alert.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        })
    }

    const checkUncheck = () => {
        $('.check-all').on('click', e => {
            $('.selected-row').prop('checked', true)
        })
        $('.uncheck-all').on('click', e => {
            $('.selected-row').prop('checked', false)
        })
    }

    const dataGridPreview = () => {
        $('.item_row').on('click', e => {
            if (!['a', 'input'].includes(e.target.tagName.toLowerCase())) {
                const datagridPreview = $('#datagridPreview')
                let id = $(e.currentTarget).data('id')
                let url = datagridPreview.data('url')
                const bsOffcanvas = new bs.Offcanvas(datagridPreview)
                bsOffcanvas.show()
                $('#datagridPreview .offcanvas-body').html('<div class="d-flex align-items-center">\n' +
                    '  <strong>Loading...</strong>\n' +
                    '  <div class="spinner-border ms-auto spinner-border-sm" role="status" aria-hidden="true"></div>\n' +
                    '</div>').load(`${url}?preview=1&id=${id}`)
            }
        })
    }

    const init = () => {
        // load current sub menu
        load($('.subMenuItem.curModuleLink').attr('href'))
        runAnchorWithAjax()
    }

    // Run all method on document ready
    $(document).ready(() => {
        init()
    })
})(jQuery, Swal, bootstrap)