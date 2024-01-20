<div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-3">
                <form id="modal-delete-form" class="row" method="post" action="">
                    @csrf
                    @method('DELETE')
                    <div class="col-12 text-center">
                        <h3 class="mb-2">Bạn chắc chắn muốn xóa?</h3>
                        <button type="submit" class="btn btn-danger me-1">Xóa</button>
                        <button type="reset" class="btn btn-outline-secondary "
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts-custom')
    <script defer>
        $(document).ready(function () {
            $(document).on('click', '.delete-record', function () {
                let action = $(this).data('action');
                $('#modal-delete-form').attr('action', action);
                $('#delete-modal').modal('show');
            });
        });
    </script>
@endpush
