@extends('Admin.layouts.main')
@push('content-header')
    @can('them_story_data')
        <div class="col ms-auto">
            @include('Admin.component.btn-add', [
                'title' => 'Thêm',
                'href' => route('admin.story.create'),
            ])
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
                        <div class="row flex-row-reverse">
                            <div class="col-12">
                                {!! \App\Helpers\SearchFormHelper::getForm(route('admin.story.index'), 'GET', [
                                    [
                                        'type' => 'text',
                                        'name' => 'search[keyword]',
                                        'placeholder' => 'Tìm truyện',
                                        'defaultValue' => request('search.keyword'),
                                    ],
                                    [
                                        'type' => 'selection',
                                        'name' => 'search[category_id]',
                                        'defaultValue' => request('search.category_id'),
                                        'options' => ['' => '- Danh mục -'] + $categories
                                    ],
                                    [
                                        'type' => 'select2',
                                        'name' => 'search[author_id]',
                                        'defaultValue' => request('search.author_id'),
                                        'options' => ['' => '- Tác giả -'] + $authors,
                                        'wrapClass' => 'col-md-3'
                                    ],
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableProducts" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ảnh</th>
                                    <th>Tên truyện</th>
                                    <th>Đánh giá</th>
                                    <th>Full chương</th>
                                    <th>Truyện hot</th>
                                    <th>Truyện mới</th>
                                    <th>Hiển thị</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stories as $story)
                                    <tr>
                                        <td></td>
                                        <td>
                                            @if ($story->image)
                                                <img src="{{ asset($story->image) }}" alt=""
                                                    style="margin-right: 5px; width:70px;"
                                                    data-image-default="{{ asset('assets/admin/images/default_image.jpg') }}">
                                            @else
                                                <img src="{{ asset('assets/admin/images/default_image.jpg') }}"
                                                    alt="" style="margin-right: 5px; width:70px;">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $story->name }}
                                        </td>
                                        <td>
                                            <form data-story-name="{{ $story->name }}" data-story-id="{{ $story->id }}">
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="number" id="stars_{{ $story->id }}"
                                                            class="form-control form-control-sm" placeholder="Số sao"
                                                            name="stars"
                                                            value="{{ isset($story->star) ? $story->star->stars : 0 }}"
                                                            required>
                                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                                            Số sao
                                                        </small>
                                                    </div>
                                                    <div class="col">
                                                        <input type="number" id="count_{{ $story->id }}"
                                                            class="form-control form-control-sm"
                                                            placeholder="Tổng lượt đánh giá" name="count"
                                                            value="{{ isset($story->star) ? $story->star->count : 0 }}"
                                                            required>
                                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                                            Tổng lượt đánh giá
                                                        </small>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button"
                                                            class="btn btn-sm btn-primary btn-save-stars">Lưu</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input class="switch_is_full switch-attribute" data-type="is_full"
                                                    type="checkbox" name="is_full"
                                                    @if ($story->is_full) checked @endif
                                                    data-id="{{ $story->id }}"
                                                    data-action="{{ route('admin.story.update.attribute', $story->id) }}"
                                                    data-method="POST">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input class="switch_is_hot switch-attribute" data-type="is_hot"
                                                    type="checkbox" name="is_hot"
                                                    @if ($story->is_hot) checked @endif
                                                    data-id="{{ $story->id }}"
                                                    data-action="{{ route('admin.story.update.attribute', $story->id) }}"
                                                    data-method="POST">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input class="switch_is_new switch-attribute" data-type="is_new"
                                                    type="checkbox" name="is_new"
                                                    @if ($story->is_new) checked @endif
                                                    data-id="{{ $story->id }}"
                                                    data-action="{{ route('admin.story.update.attribute', $story->id) }}"
                                                    data-method="POST">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input class="switch_status switch-attribute" data-type="status"
                                                    type="checkbox" name="status"
                                                    @if ($story->status) checked @endif
                                                    data-id="{{ $story->id }}"
                                                    data-action="{{ route('admin.story.update.attribute', $story->id) }}"
                                                    data-method="POST">
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('xem_chapter')
                                                    <a class="btn btn-sm btn-icon"
                                                        href="{{ route('admin.story.show', $story->id) }}">
                                                        <i data-feather="edit" class="font-medium-2 text-body"></i>
                                                    </a>
                                                @endcan
                                                @can('xoa_story_data')
                                                    <button
                                                        class="btn btn-sm btn-icon delete-story btn-danger d-flex align-items-center"
                                                        type="button" data-story-id="{{ $story->id }}"
                                                        data-story-name="{{ $story->name }}"
                                                        data-action="{{ route('admin.story.destroy', $story->id) }}"
                                                        data-method="DELETE">
                                                        <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg"
                                                            height="1em" viewBox="0 0 448 512">
                                                            <path
                                                                d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                @endcan
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1 d-flex justify-content-center">
                            {{ $stories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-custom')
    <script>
        $(document).ready(function() {
            function updateAttribute(action, type, body) {
                let data = {
                    [type]: body ? 1 : 0
                }

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': window.SuuTruyen.csrfToken,
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Cập nhập thành công",
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        if (error.status !== 500) {
                            let errorMessages = error.responseJSON.errors;
                        } else {
                            errorContent = error.responseJSON.message;
                        }
                    })
            }

            const switchAttribute = $('.switch-attribute')

            switchAttribute.on('change', function(e) {
                const method = e.target.getAttribute('data-method')
                const action = e.target.getAttribute('data-action')
                const type = e.target.getAttribute('data-type')
                const body = $(this).is(":checked")

                updateAttribute(action, type, body)
            })

            const deleteStoryBtn = $('.delete-story')
            deleteStoryBtn.on('click', function(e) {
                const storyId = $(this).attr('data-story-id')
                const storyName = $(this).attr('data-story-name')
                const action = $(this).attr('data-action')
                const method = $(this).attr('data-method')

                Swal.fire({
                    text: `Bạn có muốn xóa truyện ${storyName}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        fetch(action, {
                                method: method,
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': window.SuuTruyen.csrfToken,
                                },
                                body: JSON.stringify({
                                    id: storyId
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const trParent = e.target.closest('tr')
                                    trParent && trParent.remove()

                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: "Đã xóa thành công",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                if (error.status !== 500) {
                                    let errorMessages = error.responseJSON.errors;
                                } else {
                                    errorContent = error.responseJSON.message;
                                }
                            })
                    }
                })

            })

            const btnSaveStars = $('.btn-save-stars')
            btnSaveStars.on('click', function(e) {
                const form = $(this).closest('form')
                if (form) {
                    const storyName = form.attr('data-story-name')
                    const storyId = form.attr('data-story-id')
                    const inputStars = $(`#stars_${storyId}`)
                    const inputCount = $(`#count_${storyId}`)

                    let body = {}
                    form.serializeArray().forEach(element => {
                        body[element.name] = element.value
                    });
                    body.story_id = storyId

                    inputStars && inputStars.css('borderColor', '#d8d6de')
                    inputCount && inputCount.css('borderColor', '#d8d6de')

                    if (body.stars && body.count) {
                        fetch(`{{ route('admin.stars.update') }}`, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': window.SuuTruyen.csrfToken,
                                },
                                body: JSON.stringify(body)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: `Cập nhập đánh giá cho truyện ${storyName} thành công`,
                                        showConfirmButton: false,
                                        timer: 3000
                                    })
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                if (error.status !== 500) {
                                    let errorMessages = error.responseJSON.errors;
                                } else {
                                    // errorContent = error.responseJSON.message;
                                }
                            })
                    } else {
                        if (!body.stars) {
                            inputStars && inputStars.css('borderColor', '#dc3545')
                        }
                        if (!body.count) {
                            inputCount && inputCount.css('borderColor', '#dc3545')
                        }
                    }

                }
            })
        })
    </script>
@endpush
