window.tmp_theme = {};
tmp_theme.ajax_setup = () => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
tmp_theme.nav_click = () => {
    $(document).on('click', '.menu-toggle, .modern-nav-toggle', function (e) {
        e.preventDefault()
        let d = new Date()
            , collapsed = $('body').hasClass('menu-collapsed');
        d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000));
        document.cookie = "menu_status=" + (collapsed ? 'collapsed' : 'expanded') + ";expires=" + d.toUTCString() + ";path = /";
    });
}
tmp_theme.pickdate_submit = () => {
    $('.component-search-form .daterangepicker_v2').on('change', function () {
        $(this).parents('form').submit();
    });
}
tmp_theme.jquery_validator = () => {
    /*
     * Translated default messages for the jQuery validation plugin.
     * Locale: VI (Vietnamese; Tiếng Việt)
     */
    if (typeof $.validator != 'undefined') {
        $.extend($.validator.messages, {
            required: "Vui lòng nhập thông tin.",
            remote: "Hãy sửa cho đúng.",
            email: "Hãy nhập email.",
            url: "Hãy nhập URL.",
            date: "Hãy nhập ngày.",
            dateISO: "Hãy nhập ngày (ISO).",
            number: "Hãy nhập số.",
            digits: "Hãy nhập chữ số.",
            creditcard: "Hãy nhập số thẻ tín dụng.",
            equalTo: "Hãy nhập thêm lần nữa.",
            extension: "Phần mở rộng không đúng.",
            maxlength: $.validator.format("Hãy nhập từ {0} kí tự trở xuống."),
            minlength: $.validator.format("Hãy nhập từ {0} kí tự trở lên."),
            rangelength: $.validator.format("Hãy nhập từ {0} đến {1} kí tự."),
            range: $.validator.format("Hãy nhập từ {0} đến {1}."),
            max: $.validator.format("Hãy nhập từ {0} trở xuống."),
            min: $.validator.format("Hãy nhập từ {0} trở lên.")
        });
    }
}
tmp_theme.provinces = () => {
    let $ = jQuery
        , forms = $('form.has-provinces:not(.js-province)');
    $.each(forms, function (i, ele) {
        let form_ele = $(ele)
            , province_ele = form_ele.find('.form-province_id')
            , district_ele = form_ele.find('.form-district_id')
            , ward_ele = form_ele.find('.form-ward_id')
            , default_option_html = window['province']['default_option_html'] || '';

        form_ele.addClass('js-province');
        let reset_select = function (ele) {
            ele.find('option').remove();
            ele.append(default_option_html);
        }

        province_ele.on('change', function () {
            reset_select(district_ele);
            reset_select(ward_ele);
            let _id = $(this).val();

            if (_id !== '') {
                ajax(window['province']['route_get_districts'], 'get', {'province_id': _id})
                    .done(function (districts) {
                        $.each(districts, function (i, district) {
                            let disabled = window['province']['disabled']['districts'].indexOf(district.id) !== -1 ? 'disabled' : '';
                            let selected = window['province']['default']['districts'].indexOf(district.id) !== -1 ? 'selected' : '';
                            district_ele.append(`<option value="${district.id}" data-name="${district['district_name']}" ${disabled} ${selected}>${district['district_name']}</option>`);
                        })
                    });
            }
        });

        district_ele.on('change', function () {
            reset_select(ward_ele);
            let _id = $(this).val();

            if (_id !== '') {
                ajax(window['province']['route_get_wards'], 'get', {'district_id': _id})
                    .done(function (wards) {
                        $.each(wards, function (i, ward) {
                            let disabled = window['province']['disabled']['wards'].indexOf(ward.id) !== -1 ? 'disabled' : '';
                            let selected = window['province']['default']['wards'].indexOf(ward.id) !== -1 ? 'selected' : '';
                            ward_ele.append(`<option value="${ward.id}" data-name="${ward['ward_name']}" ${disabled} ${selected}>${ward['ward_name']}</option>`);
                        })
                    });
            }
        });
    });
}
tmp_theme.link_modal = () => {
    let $ = jQuery
        , links = $('a.has-link_modal:not(.js-link_modal)');
    $.each(links, function (i, ele) {
        let link = $(ele)
            , _href = link.attr('href');
        if (_href === '#') {
            _href = link.data('href');
        }

        link.addClass('js-link_modal');
        link.on('click', function (e) {
            e.preventDefault();
            if (_href === '#') {
                return false;
            }

            let _modal_id = link.attr('data-modal_id')
                , _ele_modal = $(`#${_modal_id}`);
            if (_modal_id && _ele_modal.length > 0) {
                _ele_modal.modal('show');
            } else {
                $.blockUI({
                    message: '<div class="spinner-border text-white" role="status"></div>',
                    css: {
                        backgroundColor: 'transparent',
                        border: '0'
                    },
                    overlayCSS: {
                        opacity: 0.5
                    }
                });
                $.get(_href, function (response) {
                    $('body').append(response['modal']);

                    let _ele_modal = $(`#${response['modal_id']}`);
                    link.attr('data-modal_id', response['modal_id']);
                    _ele_modal.remove();
                    $.unblockUI();
                    _ele_modal.modal('show');
                }).fail(function (response) {
                    if ('responseJSON' in response) {
                        tmp_theme.toastr('error', response.responseJSON.message);
                    }
                    $.unblockUI();
                });
            }
        });
    });
}
tmp_theme.modal_shown = () => {
    $(document).on('shown.bs.modal', 'div.modal', function (event) {
        tmp_theme.provinces();
        tmp_theme.form_validate();
        tmp_theme.feather();
        if (typeof $().select2 === 'function') {
            let _id = $(this).attr('id');
            $('.has-select2:not(.js-select2)').each(function () {
                let _this = $(this);
                _this.addClass('js-select2');
                _this.select2({
                    dropdownParent: $(`#${_id}`)
                });
            });
        }

        tmp_theme.popover();
    });
}
tmp_theme.deleteResource = () => {
    $(`.btn-delete-row-table`).on('click', function () {
        let route = $(this).attr('data-action');
        let title = $(this).attr('data-title');

        Swal.fire({
            title: title,
            showDenyButton: true,
            denyButtonText: 'Không',
            confirmButtonText: 'Xóa',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                ajax(route, 'DELETE', null).done(async (response) => {
                    await Swal.fire({
                        position: 'center',
                        icon: response.icon,
                        title: response.message,
                        showConfirmButton: false,
                        showCloseButton: false,
                        timer: 1500
                    }).then(() => {
                        console.log(1);
                        window.location.reload();
                    });
                }).fail((error) => {
                    console.log(error);
                    alert('Server has an error. Please try again!');
                });
            }
        })
    })
}

tmp_theme.form_repeater = () => {
    $('.wrap-repeater:not(.js-repeater)').each(function (i, w) {
        $(w).addClass('js-repeater');
        $(w).repeater({
            show: function () {
                $('.flatpickr-basic').flatpickr();
                $(this).slideDown();
                $('.select2-container').remove();
                $('.has-select2').removeClass('js-select2');
                // $('.wrap-repeater').removeClass('js-repeater');
                tmp_theme.select2();
                // tmp_theme.form_repeater();
                tmp_theme.feather();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
            repeaters: [{
                selector: '.inner-repeater'
            }]
        });
    });
}
tmp_theme.form_validate = () => {
    let $ = jQuery
        , options = {};
    if (typeof $.fn.validate != 'undefined') {
        $('.form-validate').validate(options);
    }
}
tmp_theme.form_block = (_form) => {
    _form.block({
        message: '<div class="spinner-border text-white" role="status"></div>',
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
}
tmp_theme.form_unblock = (_form) => {
    _form.unblock();
}
tmp_theme.form_ajax_success_callback = (_form, response) => {
    tmp_theme.form_unblock(_form);
    if ('redirect' in response) {
        location.href = response.redirect;
    } else if ('reload' in response) {
        location.reload();
    } else if ('message' in response) {
        tmp_theme.toastr('success', response['message']);
    }
}
tmp_theme.form_ajax_error_callback = (_form, response) => {
    tmp_theme.form_unblock(_form);
    if ('responseJSON' in response && 'errors' in response['responseJSON']) {
        let error_html = tmp_theme.alert_render(response['responseJSON']['errors']);
        _form.find('.modal-alert').html('').append(error_html);
    }
    if ('message' in response) {
        tmp_theme.toastr('error', response['message']);
    }
}
tmp_theme.form_ajax_submit = (_form, success_callback, error_callback) => {
    tmp_theme.form_block(_form);
    let form_data = new FormData(_form[0])
        , _method = _form.attr('method')
        , _action = _form.attr('action');

    if (typeof success_callback === 'undefined') {
        success_callback = function (response) {
            tmp_theme.form_ajax_success_callback(_form, response);
        };
    }
    if (typeof error_callback === 'undefined') {
        error_callback = function (response) {
            tmp_theme.form_ajax_error_callback(_form, response);
        };
    }

    $.ajax({
        method: _method,
        url: _action,
        data: form_data,
        contentType: false,
        processData: false,
        success: success_callback,
        error: error_callback
    });
}
tmp_theme.alert_render = (errors) => {
    let li = '';
    $.each(errors, function (key, values) {
        $.each(values, function (i, e) {
            li += `<li>${e}</li>`;
        })
    });

    return `<div class="alert alert-danger" role="alert">
    <div class="alert-body">
        <div class="fw-bold">Đã có lỗi xảy ra</div>
        <ul class="mb-0">${li}</ul>
    </div>
</div>`;
}
tmp_theme.toastr = (type, message) => {
    if (typeof toastr === 'object') {
        toastr[type](message, '', {
            closeButton: true,
            tapToDismiss: true
        });
    }
}
tmp_theme.get_token = () => {
    return document.querySelector('meta[name="csrf-token"]').content;
}
tmp_theme.select2 = () => {
    if (typeof $().select2 === 'function') {
        $('.has-select2:not(.js-select2)').each(function () {
            let _this = $(this)
                , _options = {}
                , _dropdown_parent = _this.data('dropdown_parent')
                , _placeholder = _this.attr('placeholder');
            _this.addClass('js-select2');
            if (_dropdown_parent) {
                _options['dropdownParent'] = $(_dropdown_parent);
            }
            if (_placeholder) {
                _options['placeholder'] = {
                    id: '-1', // the value of the option
                    text: _placeholder
                };
            }
            _options['templateResult'] = tmp_theme.select2_level;
            _this.select2(_options);
        });
    }
}
tmp_theme.select2_level = function (state) {
    if ($(state.element).css('display') === 'none') {
        return null;
    }
    if (!state.id) {
        return state.text;
    }
    let _text = state.text
        , _level = state.element.getAttribute('data-level')
        , _mobile = window.innerWidth < 768
        , _prefix = _mobile ? '|-- ' : '| - - ';

    return (_level ? (_prefix.repeat(_level)) : '') + _text;
}
tmp_theme.select2_open = () => {
    $(document).on('select2:open', () => {
        let allFound = document.querySelectorAll('.select2-container--open .select2-search__field');
        allFound[allFound.length - 1].focus();
    });
}

tmp_theme.popover = () => {
    if (typeof $().popover === 'function') {
        $('.tooltipcustom').each(function () {
            let _this = $(this);
            let txt = _this.data('content');
            _this.popover({
                container: 'body',
                trigger: 'hover',
                html: true,
                content: txt,
            });
        });
    }
}

tmp_theme.pagination = () => {
    $(document).on('click', '.pagination:not(.pagination-no--js) .page-link', function (event) {
        let _this = $(this)
            , _modal = _this.closest('.modal')
            , _href = _this.attr('href');
        if (!_href) {
            return false;
        }
        if (_modal.length > 0) {
            event.preventDefault();
            let _modal_body = $('.modal-body', _modal);
            _modal_body.block({
                message: '<div class="spinner-border text-white" role="status"></div>',
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    opacity: 0.5
                }
            });

            $.ajax({
                method: 'get',
                url: _href,
                data: {'is_modal': true},
                success: function (response) {
                    if ('modal_body' in response) {
                        _modal_body.html(response['modal_body']);
                    }
                    _modal_body.unblock();
                    tmp_theme.popover();
                },
                error: function (response) {
                    tmp_theme.toastr('error', 'Tải dữ liệu không thành công.');
                    _modal_body.unblock();
                }
            });
        }
    });
}
tmp_theme.setting_per_page = (ele) => {
    let _val = $(ele).val()
        , _url = $(ele).data('url')
        , _name = $(ele).data('name');
    $.ajax({
        url: _url,
        type: "POST",
        dataType: 'html',
        data: {
            _token: tmp_theme.get_token(),
            name: _name,
            number: _val
        },
        success: function (response) {
            location.reload();
        }
    });
}
tmp_theme.user_validate = (obj) => {
    let ele = $(obj)
        , _form = ele.closest('form');
    _form.validate();
}
tmp_theme.user_submit = () => {
    $(document).on('submit', '.form-update-user', function () {
        let _form = $(this)
            , _valid = _form.valid()
        ;
        if (!_valid) {
            return false;
        }
        tmp_theme.form_ajax_submit(_form);
        return false;
    });
}

tmp_theme.custom_modal_livewire = () => {
    $('.js-show-modal').on('click', function (e) {
        livewire.emit('setCurrentCustomerLSTD', $(this).data('id'));
        $('#customer_history_tich_diem').modal('show');
    });
}
tmp_theme.input_numeral_mask = () => {
    $('.numeral-mask:not(.js-numeral-mask)').each(function (i, e) {
        $(e).addClass('js-numeral-mask');
        new Cleave(e, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            swapHiddenInput: true
        });
    });
}

tmp_theme.change_paginate_table = () => {
    $(document).on('change', '.change-paginate-table', function () {
        let paginate = $(this).val();
        var url = $.query.set("options[perPage]", paginate).toString();

        document.location = url;
    });
}

tmp_theme.feather = () => {
    if (feather) {
        feather.replace({width: 14, height: 14});
    }
}

tmp_theme.table_check_all = (_table) => {
    let _check_all_ele = _table.find('#checkAll')
        , _total_checkbox = _table.find('.row-check').length;

    _check_all_ele.on('click', function () {
        _table.find('.row-check').prop('checked', $(this).is(':checked'));
    });
    _table.find('.row-check').on('click', function () {
        let total_checked = _table.find('.row-check:is(:checked)').length;
        console.log(total_checked, _total_checkbox);
        _check_all_ele.prop('checked', total_checked === _total_checkbox);
    });
}

tmp_theme.change_order_by_table = () => {
    $(document).on('click', '.table-column-sorting', function () {
        let key = $(this).attr('data-sort-key');
        let type = $(this).attr('data-sort-type');
        let orderBy = $.query.get("options[orderBy]");

        let typeOrder = ''
        switch (type) {
            case "ASC":
                typeOrder = "DESC";
                $(this).removeClass('column-order-asc');
                $(this).addClass('column-order-desc');
                break;
            case "DESC":
                typeOrder = "";
                $(this).removeClass('column-order-desc');
                $(this).removeClass('column-order-asc');
                break;
            default:
                typeOrder = "ASC";
                $(this).removeClass('column-order-desc');
                $(this).addClass('column-order-asc');
                break;
        }

        if (orderBy.length > 0) {
            let isUpdateQuery = false;
            orderBy.map(function (condition) {
                if (condition.column === key) {
                    condition.type = typeOrder;
                    isUpdateQuery = true;
                }

                return condition;
            })

            orderBy = orderBy.filter(function (condition) {
                return condition.type === 'ASC' || condition.type === 'DESC';
            })

            if (!isUpdateQuery) {
                orderBy.push({
                    column: key,
                    type: typeOrder
                })
            }
        } else {
            orderBy = [
                {
                    column: key,
                    type: typeOrder
                }
            ]
        }

        let query = '';
        if (orderBy.length === 0) {
            query = $.query.REMOVE("options[orderBy]").toString()
        } else {
            query = $.query.set("options[orderBy]", orderBy).toString();
        }

        if (query === '') {
            query = window.location.href.replace(window.location.search, '');
        }

        document.location = query;
    });
}

tmp_theme.component_search_form_mobile = () => {
    let component_search_form = $('.component-search-form:not(.open_form_mobile)');
    const urlParams = new URLSearchParams(window.location.search);
    let searchParam = new Array()
    urlParams.forEach((value, key) => {
        searchParam.push(key)
    });
    if (component_search_form.length) {
        if (window.innerWidth < 768 && searchParam.length === 0) {
            component_search_form.addClass('mobile');
        }
        component_search_form.submit(function () {
            if ($(this).hasClass('mobile')) {
                $(this).removeClass('mobile');
                return false;
            }
        });
    }
}

tmp_theme.component_view_image = () => {
    let modal = document.getElementById('zoomImageModal');
    let modalImg = document.getElementById("img01");
    $('.thumb').on('click', function () {
        modal.style.display = "block";
        modalImg.src = this.src;
    })

    $('#zoomImageModal .close').on('click', function () {
        modal.style.display = "none";
    })
}

tmp_theme.alert_success = (message) => {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: message,
        showConfirmButton: true,
        timer: 5000
    })
}

tmp_theme.alert_warning = (message, confiOkrmButtonName = '') => {
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: message,
        showConfirmButton: true,
        confirmButtonText: confiOkrmButtonName,
        timer: 5000
    })
}

tmp_theme.alert_error = (message) => {
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: message,
        showConfirmButton: true,
        timer: 5000
    })
}

tmp_theme.init = () => {
    tmp_theme.ajax_setup();
    tmp_theme.nav_click();
    tmp_theme.jquery_validator();
    tmp_theme.provinces();
    tmp_theme.link_modal();
    tmp_theme.modal_shown();
    tmp_theme.form_validate();
    tmp_theme.select2();
    tmp_theme.popover();
    tmp_theme.select2_open();
    tmp_theme.pagination();
    tmp_theme.user_submit();
    tmp_theme.custom_modal_livewire();
    tmp_theme.form_repeater();
    tmp_theme.input_numeral_mask();
    tmp_theme.change_paginate_table();
    tmp_theme.change_order_by_table();
    tmp_theme.component_search_form_mobile();
    tmp_theme.deleteResource();
    tmp_theme.component_view_image();
    tmp_theme.pickdate_submit();
}

$(document).ready(function () {
    tmp_theme.init();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.ajax = function (url, method, data) {
        return $.ajax({
            url,
            type: method,
            data
        })
    }

    window.loadingFullPage = function () {
        let elementLoading = $('#loadingPage');
        let status = elementLoading.css('display');
        if (status == 'none') {
            elementLoading.css('display', 'flex');
            $('body').css('overflow', 'hidden');
        } else {
            elementLoading.css('display', 'none');
            $('body').css('overflow', 'unset');
        }
    }
});
