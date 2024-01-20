@extends('Admin.layouts.main')
@push('content-header')
    @can('xem_crawl_data')
        <div class="col ms-auto">
            {{-- @include('Admin.component.btn-add', ['title'=>'Thêm', 'href'=>route('admin.crawl.create')]) --}}
        </div>
    @endcan
@endpush
@section('content')
    <section class="app-user-list">
        <div class="row" id="table-striped">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success p-1">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form id="form-crawl" class="form-validate" method="post" autocomplete="off"
                            action="{{ route('admin.crawl.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-6">
                                    <div class="col-12 mb-1">
                                        <label class="form-label" for="basic-icon-default-name">Link crawl from</label>
                                        <input type="text" id="basic-icon-default-name" class="form-control"
                                            name="link_crawl_from" placeholder="https://truyenfull.vn/am-nhat/trang-1"
                                            value="{{ old('link_crawl_from') }}" required />
                                    </div>
                                    <div class="col-12 mb-1">
                                        <label class="form-label" for="basic-icon-default-name">Link crawl to</label>
                                        <input type="text" id="basic-icon-default-name" class="form-control"
                                            name="link_crawl_to" placeholder="https://truyenfull.vn/am-nhat/trang-9"
                                            value="{{ old('link_crawl_to') }}" required />
                                    </div>
                                </div>
                            </div>


                            <div class="mt-3">
                                <button id="btn_crawl" type="button" class="btn btn-success me-1">
                                    Crawl
                                    <div class="spinner-border spinner-border-sm d-none text-warning" role="status">

                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-custom')
    <script>
        $(document).ready(function() {
            const btnCrawl = $('#btn_crawl')
            const spinner = $('#btn_crawl .spinner-border')

            btnCrawl.on('click', function(e) {
                btnCrawl.attr('disabled', 'disabled')
                spinner.removeClass('d-none')

                const formCrawl = $('#form-crawl')
                const action = formCrawl.attr('action')
                const method = formCrawl.attr('method')
                const body = formCrawl.serializeArray()

                let timerInterval
                const preLoading = Swal.fire({
                    title: 'Đang tiến hành Crawl truyện!',
                    html: 'Vui lòng đợi ...',
                    // timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()

                        // setTimeout(() => {
                        //     Swal.hideLoading()
                        // }, 2000);
                    },
                    willClose: () => {

                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the timer')
                    }
                })

                $.ajax({
                    action,
                    method,
                    data: body,
                }).then(function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: "Thêm mới truyện thành công",
                            showConfirmButton: false,
                            // timer: 2000
                        })
                    }

                    btnCrawl.removeAttr('disabled')
                    spinner.addClass('d-none')
                }).catch(function(error) {
                    console.log(error);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: "Chưa nhập đầy đủ hoặc hệ thống đang gặp lỗi",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    btnCrawl.removeAttr('disabled')
                    spinner.addClass('d-none')
                })
            })
        })
    </script>
@endpush
