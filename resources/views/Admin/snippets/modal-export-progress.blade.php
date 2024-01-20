<div
        class="modal fade"
        id="{{$idExportModal}}"
        tabindex="-1"
        aria-labelledby="modal_export_progress_Title"
        aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_export_progress_Title">Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="wrapper-progress">
                    <div class="progress progress-bar-success">
                        <div
                                class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar"
                                aria-valuenow="0"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                style=""
                        >
                            0%
                        </div>
                    </div>
                    <div class="progress-info" style="display: grid;grid-template-columns: 100px auto;gap: 5px;"></div>
                    <pre class="progress-error text-danger"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts-custom')
    <script defer>
        window.onbeforeunload = function (e) {
            if ($('.export-js.disabled').length) {
                return 'Đang xuất dữ liệu, bạn có muốn dừng không?';
            }
        };
        $(document).ready(function () {
            $('.export-js').on('click', function () {
                let _this = $(this)
                    , _wrap = $('.wrapper-progress')
                    , _wrap_error = $('.progress-error', _wrap)
                    , _progress_bar = $('.progress-bar', _wrap)
                    , _progress_info = $('.progress-info', _wrap);
                if (_this.hasClass('disabled')) {
                    return;
                }
                _progress_bar.attr('aria-valuenow', 0);
                _progress_bar.width(`0%`);
                _progress_bar.text(`0%`);
                _progress_info.html(``);

                _this.addClass('disabled');
                _wrap_error.text('');

                let _href = $(this).attr('data-href'),
                    _progress = function (response) {
                        if ('percent' in response) {
                            _progress_bar.attr('aria-valuenow', response['percent']);
                            _progress_bar.width(`${response['percent']}%`);
                            _progress_bar.text(`${response['percent']}%`);
                        }
                        if ('progress_info' in response) {
                            _progress_info.html(response['progress_info']);
                        }
                    },
                    _done = function () {
                        _this.removeClass('disabled');
                    }
                    , _action = function (_form_data) {
                        $.ajax({
                            method: 'post',
                            url: _href,
                            data: _form_data,
                            success: function (response) {
                                _progress(response);
                                if (response['done']) {
                                    _done(response);
                                } else {
                                    setTimeout(function () {
                                        _action(response);
                                    }, 1e3);
                                }
                            },
                            error: function (response) {
                                if ('responseText' in response) {
                                    _wrap_error.text(response['responseText']);
                                }
                                _this.removeClass('disabled');
                            }
                        });
                    };
                _action({});
            });
        });
    </script>
@endpush
