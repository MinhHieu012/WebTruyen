@extends('Admin.layouts.main')
{{-- @push('content-header') --}}
{{-- @can('xem_crawl_data') --}}
{{-- <div class="col ms-auto"> --}}
{{-- @include('Admin.component.btn-add', ['title'=>'Thêm', 'href'=>route('admin.crawl.create')]) --}}
{{-- </div> --}}
{{-- @endcan --}}
{{-- @endpush --}}
@section('content')
    <div class="row">

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success p-1">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 col-md-6">
                            @if ($ratingsDay)
                                @php
                                    $value = json_decode($ratingsDay->value, true);
                                @endphp
                                <div class="column mb-2" id="column1">
                                    <h2>Xếp hạng <b>ngày</b></h2>
                                    <div class="dd" id="nestable1">
                                        <ol class="dd-list">
                                            @foreach ($value as $item)
                                                <li class="dd-item" data-id="{{ $item['id'] }}"
                                                    data-name="{{ $item['name'] }}">
                                                    <div
                                                        class="dd-handle d-flex justify-content-between align-items-center">
                                                        <span>{{ $item['name'] }}</span>
                                                        <button
                                                            class="dd-nodrag btn btn-sm btn-icon delete-story-rating btn-danger d-flex align-items-center"
                                                            type="button">
                                                            <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg"
                                                                height="1em"
                                                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                <path
                                                                    d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            @else
                                <div class="column mb-2" id="column1">
                                    <h2>Xếp hạng <b>ngày</b></h2>
                                    <div class="dd" id="nestable1">
                                        <ol class="dd-list"></ol>
                                    </div>
                                </div>
                            @endif

                            @if ($ratingsMonth)
                                @php
                                    $value = json_decode($ratingsMonth->value, true);
                                @endphp
                                <div class="column mb-2" id="column2">
                                    <h2>Xếp hạng <b>tháng</b></h2>
                                    <div class="dd" id="nestable2">
                                        <ol class="dd-list">
                                            @foreach ($value as $item)
                                                <li class="dd-item" data-id="{{ $item['id'] }}"
                                                    data-name="{{ $item['name'] }}">
                                                    <div
                                                        class="dd-handle d-flex justify-content-between align-items-center">
                                                        <span>{{ $item['name'] }}</span>
                                                        <button
                                                            class="dd-nodrag btn btn-sm btn-icon delete-story-rating btn-danger d-flex align-items-center"
                                                            type="button">
                                                            <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg"
                                                                height="1em"
                                                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                <path
                                                                    d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            @else
                                <div class="column mb-2" id="column2">
                                    <h2>Xếp hạng <b>tháng</b></h2>
                                    <div class="dd" id="nestable2">
                                        <ol class="dd-list">

                                        </ol>
                                    </div>
                                </div>
                            @endif

                            @if ($ratingsAllTime)
                                @php
                                    $value = json_decode($ratingsMonth->value, true);
                                @endphp
                                <div class="column mb-2" id="column3">
                                    <h2>Xếp hạng <b>all time</b></h2>
                                    <div class="dd" id="nestable3">
                                        <ol class="dd-list">
                                            @foreach ($value as $item)
                                                <li class="dd-item" data-id="{{ $item['id'] }}"
                                                    data-name="{{ $item['name'] }}">
                                                    <div
                                                        class="dd-handle d-flex justify-content-between align-items-center">
                                                        <span>{{ $item['name'] }}</span>
                                                        <button
                                                            class="dd-nodrag btn btn-sm btn-icon delete-story-rating btn-danger d-flex align-items-center"
                                                            type="button">
                                                            <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg"
                                                                height="1em"
                                                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                <path
                                                                    d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            @else
                                <div class="column mb-2" id="column3">
                                    <h2>Xếp hạng <b>all time</b></h2>
                                    <div class="dd" id="nestable3">
                                        <ol class="dd-list">

                                        </ol>
                                    </div>
                                </div>
                            @endif

                            @can('sua_rating_data')
                                <button class="btn btn-primary" id="btn_save_ratings"
                                    data-action="{{ route('admin.rating.update') }}" data-method="POST">
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="text-save-ratings">Cập nhật</span>
                                </button>
                            @endcan

                        </div>

                        <div class="col-12 col-md-6">
                            <h2>Danh sách truyện</h2>
                            <div class="d-flex-wrap">
                                @if ($stories->count() > 0)
                                    @foreach ($stories as $story)
                                        <div class="btn-group me-1 mb-1 story-btn" data-story-id="{{ $story->id }}"
                                            data-story-name="{{ $story->name }}">
                                            <button type="button" class="btn btn-outline-success dropdown-toggle btn-sm"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $story->name }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><span class="dropdown-item btn-story-rating" data-type="day">Thêm
                                                        vào xếp hạng
                                                        ngày</span></li>
                                                <li><span class="dropdown-item btn-story-rating" data-type="month">Thêm
                                                        vào xếp hạng
                                                        tháng</span></li>
                                                <li><span class="dropdown-item btn-story-rating" data-type="all_time">Thêm
                                                        vào xếp hạng
                                                        all time</span></li>
                                            </ul>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-page-vendor')
    <link rel="stylesheet" href="{{ mix('assets/admin/vendors/css/nestable2/jquery.nestable.min.css') }}" />
    <script src="{{ mix('assets/admin/vendors/js/nestable2/jquery.nestable.min.js') }}"></script>
@endpush

@push('scripts-custom')
    <script>
        $(document).ready(function() {
            $('#nestable1, #nestable2, #nestable3').nestable();

            $('#nestable1').on('change', function() {
                var serializedData1 = $('#nestable1').nestable('serialize');
                console.log('Column 1:', serializedData1);
            });

            $('#nestable2').on('change', function() {
                var serializedData2 = $('#nestable2').nestable('serialize');
                console.log('Column 2:', serializedData2);
            });

            $('#nestable3').on('change', function() {
                var serializedData3 = $('#nestable3').nestable('serialize');
                console.log('Column 3:', serializedData3);
            });

            $('.btn-story-rating').on('click', function(e) {
                const storyBtn = $(this).closest('.story-btn')
                const storyId = storyBtn.attr('data-story-id')
                const storyName = storyBtn.attr('data-story-name')
                const typeRating = $(this).attr('data-type')

                let objRating = [{
                        type: 'day',
                        nestable: 1,
                        name: 'ngày'
                    },
                    {
                        type: 'month',
                        nestable: 2,
                        name: 'tháng'
                    },
                    {
                        type: 'all_time',
                        nestable: 3,
                        name: 'all time'
                    }
                ]

                var newItemId = storyId;
                var newItemHtml =
                    `<li class="dd-item" data-id="${newItemId}" data-name="${storyName}">
                        <div class="dd-handle d-flex justify-content-between align-items-center">
                            <span>${storyName}</span>
                            <button class="dd-nodrag btn btn-sm btn-icon delete-story-rating btn-danger d-flex align-items-center" type="button">
                                <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
                            </button>
                        </div>
                    </li>`

                objRating.forEach(element => {
                    if (element.type == typeRating) {
                        const serializedData = $(`#nestable${element.nestable}`).nestable(
                            'serialize');
                        let itemExist = serializedData.find((item) => {
                            return item.id == storyId
                        })

                        if (!itemExist) {
                            $(`#nestable${element.nestable} ol.dd-list`).append(newItemHtml);
                            $(`#nestable${element.nestable}`).nestable('reload')

                            const ddEmpty = document.querySelector(
                                `#nestable${element.nestable} .dd-empty`)
                            if (ddEmpty) {
                                ddEmpty.remove()
                            }
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: `Bạn đã thêm truyện ${storyName} vào cột xếp hạng ${element.name}`,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    }
                });
            })

            $("#btn_save_ratings").on('click', function(e) {
                const textSaveRatings = $(this).children('.text-save-ratings')
                const spinner = $(this).children('.spinner-border')
                const action = $(this).attr('data-action')
                const method = $(this).attr('data-method')

                const body = {
                    // day: $('#nestable1').nestable('serialize'),
                    // month: $('#nestable2').nestable('serialize'),
                    // all_time: $('#nestable3').nestable('serialize')
                }

                if ($('#nestable1').nestable('serialize').length > 0) {
                    body.day = $('#nestable1').nestable('serialize')
                }

                if ($('#nestable2').nestable('serialize').length > 0) {
                    body.month = $('#nestable2').nestable('serialize')
                }

                if ($('#nestable3').nestable('serialize').length > 0) {
                    body.all_time = $('#nestable3').nestable('serialize')
                }


                if (body) {
                    textSaveRatings.addClass('d-none')
                    spinner.removeClass('d-none')

                    $.ajax({
                        action,
                        method,
                        data: body,
                    }).then(function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Cập nhập thành công",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                        textSaveRatings.removeClass('d-none')
                        spinner.addClass('d-none')
                    }).catch(function(error) {
                        if (error.status !== 500) {
                            let errorMessages = error.responseJSON.errors;
                        } else {
                            errorContent = error.responseJSON.message;
                        }

                        textSaveRatings.removeClass('d-none')
                        spinner.addClass('d-none')
                        if (error.status == 403) {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: "Bạn không được cấp quyên để cập nhật Rating",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    })
                }
            })

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-story-rating') || e.target.closest(
                        '.delete-story-rating')) {
                    const dd = e.target.closest('.dd')

                    if (dd) {
                        const id = dd.getAttribute('id')
                        e.target.closest('.dd-item').remove();
                        $(`#${id}`).nestable('reload');
                        const sortNew = $(`#${id}`).nestable('serialize')
                    }
                }
            })
        });
    </script>
@endpush
