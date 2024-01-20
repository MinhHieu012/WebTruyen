@extends('Admin.layouts.main')

@section('content')
    <section class="">
        <div class="row">

        </div>

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
                            action="{{ route('admin.display.update') }}">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="col-12 mb-1">
                                        {!! FormUi::text('title', 'Title site', $errors, $setting, []) !!}
                                    </div>
                                    <div class="col-12 mb-1">
                                        {!! FormUi::text('description', 'Description site', $errors, $setting, []) !!}
                                    </div>
                                    <div class="col-12 mb-1">
                                    {!! FormUi::checkbox('index', 'Index', '', $errors, $setting) !!}
                                    </div>
                                    <div class="col-12 mb-1">
                                        {!! FormUi::textarea('header_script', 'Header script', $errors, $setting, []) !!}
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="col-12 mb-1">
                                        {!! FormUi::textarea('body_script', 'Body script', $errors, $setting, []) !!}
                                    </div>
                                    <div class="col-12 mb-1">
                                        {!! FormUi::textarea('footer_script', 'Footer script', $errors, $setting, []) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="">
                                <button type="submit" class="btn btn-success me-1">
                                    Cập nhật
                                </button>
                                {{-- <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-1">
                                <i data-feather='rotate-ccw'></i>
                                Quay lại
                            </a> --}}
                            </div>
                        </form>
                    </div>

                    {{-- <div class="table-responsive">
                    <table id="tableProducts" class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>IP đăng nhập<br>gần nhất</th>
                            <th>TG đăng nhập<br>gần nhất</th>
                            <th>Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>
                     
                        </tbody>
                    </table>
                </div> --}}

                    <div class="row">
                        <div class="col-sm-12 mt-1 d-flex justify-content-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
