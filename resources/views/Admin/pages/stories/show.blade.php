@extends('Admin.layouts.main')
@section('page_title')
    {{ $story->name ?? 'Thêm truyện' }}
@endsection
@push('content-header')
    {{-- @can('them_category')
        <div class="col ms-auto">
            @include('Admin.component.btn-add', [
                'title' => 'Thêm',
                'href' => route('admin.category.create'),
            ])
        </div>
    @endcan --}}
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

                        <div class="row mb-2">
                            <form action="{{ $formOptions['action'] }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method($formOptions['method'])
                                <div class="col-12 col-md-12 mb-1">
                                    {{-- <h4 class="text-dark">Tác giả: {{ $story->author->name ?? '' }}</h4> --}}
                                    {!! FormUi::text('name', 'Tên truyện', $errors, $story, []) !!}
                                </div>
                                <div class="col-12 col-md-12 mb-1">
                                    {!! FormUi::text('slug', 'Slug', $errors, $story, []) !!}
                                </div>
                                <div class="col-12 col-md-12 mb-1">
                                    <div class="col-12 col-md-12 mb-1">
                                        {!! FormUi::select('author_id', 'Tác giả', $errors, $authors, $story, []) !!}
                                    </div>
                                    <div class="col-12 col-md-12 mb-1">
                                        <label for="categories" class="col-md-3 control-label text-left">Danh mục</label>
                                        <div class="col-md-9">
                                            <select id="category_ids" name="category_ids[]" class="form-control has-select2"
                                                multiple="multiple">
                                                <option value="">- Chọn danh mục -</option>
                                                @foreach ($categories as $category_id => $category_name)
                                                    <option value="{{ $category_id }}"
                                                        {{ in_array($category_id, array_keys($categories_belong)) ? 'selected' : '' }}>
                                                        {{ $category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-1">
                                        {!! FormUi::wysiwyg('desc', 'Mô tả', $errors, $story, []) !!}
                                    </div>
                                    <div class="col-12 col-md-12 mb-1">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('status', 'Hiển thị', '', $errors, $story) !!}
                                            </div>
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('is_full', 'Full chương', '', $errors, $story) !!}
                                            </div>
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('is_new', 'Mới nhất', '', $errors, $story) !!}
                                            </div>
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('hot_day', 'Hot day', '', $errors, $story) !!}
                                            </div>
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('hot_month', 'Hot month', '', $errors, $story) !!}
                                            </div>
                                            <div class="col-6 col-md-4">
                                                {!! FormUi::checkbox('hot_all_time', 'Hot all time', '', $errors, $story) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-1">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ asset($story->image ?? '') }}" alt=""
                                                style="margin-right: 5px; width:250px;" id="image_story"
                                                data-image-default="{{ asset('assets/admin/images/default_image.jpg') }}">
                                            <input type="file" name="image" class="d-none" id="choose_file_image">
                                            <div class="action-image d-flex">
                                                <button type="button" class="btn btn-danger" id="remove_image"
                                                    style="margin-right: 5px;">Xóa</button>
                                                <button type="button" class="btn btn-success" id="choose_image">Chọn
                                                    ảnh</button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Cập nhật</button>
                                    </div>
                            </form>
                        </div>
                        <hr>

                        @if ($story)
                            <div class="row">
                                <div class="col">
                                    {!! \App\Helpers\SearchFormHelper::getForm(route('admin.story.show', $story->id), 'GET', [
                                        [
                                            'type' => 'text',
                                            'name' => 'search[keyword]',
                                            'placeholder' => 'Tìm chapter',
                                            'defaultValue' => request('search.keyword'),
                                        ],
                                    ]) !!}
                                </div>


                                @can('them_chapter')
                                    <div class="col ms-auto">
                                        @include('Admin.component.btn-add', [
                                            'title' => 'Thêm chapter',
                                            'href' => route('admin.chapter.create', ['story_id' => $story->id]),
                                        ])
                                    </div>
                                @endcan
                            </div>
                        @endif

                    </div>

                    @if ($story)
                        @if (count($chapters) > 0)
                            <div class="table-responsive">
                                <table id="tableProducts" class="table table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th class=" text-center text-nowrap align-middle" style="">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th> --}}
                                            <th>Tên chương</th>
                                            <th>Chương mới</th>
                                            <th>Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chapters as $chapter)
                                            <tr>
                                                {{-- <td class="text-center">
                                        <input class="form-check-input row-check" type="checkbox" value="{{ $chapter->id }}">
                                    </td> --}}
                                                <td>
                                                    {{ $chapter->name }}
                                                </td>
                                                <td>
                                                    <label class="switch">
                                                        <input class="switch_is_full switch-attribute" data-type="is_full"
                                                            type="checkbox" name="is_full"
                                                            @if ($chapter->is_new) checked @endif
                                                            data-id="{{ $chapter->id }}"
                                                            {{-- data-action="{{ route('admin.chapter.update.attribute', $chapter->id) }}" --}}
                                                            data-method="POST">
                                                        <span class="slider"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        @can('sua_chapter')
                                                            <a class="btn btn-sm btn-icon"
                                                                href="{{ route('admin.chapter.edit', $chapter->id) }}">
                                                                <i data-feather="edit" class="font-medium-2 text-body"></i>
                                                            </a>
                                                        @endcan
                                                        @can('xoa_chapter')
                                                            <button
                                                                class="btn btn-sm btn-icon delete-chapter btn-danger d-flex align-items-center"
                                                                type="button" data-chapter-id="{{ $chapter->id }}"
                                                                data-chapter-name="{{ $chapter->name }}"
                                                                data-action="{{ route('admin.chapter.destroy', $chapter->id) }}"
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
                                    {{ $chapters->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @else
                            <p class="text-warning fs-4 fw-bold">Bạn hãy thêm chương mới cho truyện này</p>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts-custom')
    <script>
        $(document).ready(function() {
            const imageStory = document.querySelector('#image_story')
            const btnRemoveImage = document.querySelector('#remove_image')
            const btnChooseImage = document.querySelector('#choose_image')

            btnRemoveImage.addEventListener('click', function() {
                if (imageStory) {
                    imageStory.setAttribute('src', imageStory.getAttribute('data-image-default'))
                }
            })

            const inputFileImage = document.querySelector('#choose_file_image')
            btnChooseImage.addEventListener('click', function() {
                if (inputFileImage) {
                    inputFileImage.click()
                }
            })

            inputFileImage.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('preview');
                const clearButton = document.getElementById('clear');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imageStory.src = e.target.result;
                        btnRemoveImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imageStory.src = imageStory.getAttribute('data-image-default'); // Ảnh mặc định
                    btnRemoveImage.style.display = 'none';
                }
            })

            const deleteChapterBtn = $('.delete-chapter')
            deleteChapterBtn.on('click', function(e) {
                const chapterId = $(this).attr('data-chapter-id')
                const chapterName = $(this).attr('data-chapter-name')
                const action = $(this).attr('data-action')
                const method = $(this).attr('data-method')

                Swal.fire({
                    text: `Bạn có muốn xóa ${chapterName}`,
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
                                    id: chapterId
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
        })
    </script>
@endpush
