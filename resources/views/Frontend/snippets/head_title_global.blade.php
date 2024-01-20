<div class="head-title-global d-flex justify-content-between mb-2">
    <div class="col-6 col-md-4 col-lg-4 head-title-global__left d-flex align-items-center">
        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
            <a href="#" class="d-block text-decoration-none text-dark fs-4 story-name" title="{{ $title }}">{{ $title }}</a>
        </h2>
        @if ($showIcon)
        <i class="fa-solid fa-fire-flame-curved"></i>
        @endif
    </div>

    @if ($showSelect && count($selectOptions))
    <div class="col-4 col-md-3 col-lg-2">
        <select class="form-select {{ $classSelect }}" aria-label="Truyen hot">
            <option selected>Tất cả</option>
            @foreach ($selectOptions as $item)
            <option value="{{ $item->id }}" @if ($item->id == $categoryIdSelected)
                checked
            @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    @endif
</div>