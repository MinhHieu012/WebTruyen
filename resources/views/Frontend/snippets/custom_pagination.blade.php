{{-- @dd($has_ajax) --}}
@php
    $class = $has_ajax ? 'story-ajax-paginate' : '';
@endphp
@if ($paginator->hasPages())

    <ul>
        @if ($paginator->currentPage() > 1)
            <li class=" pagination__arrow pagination__item">

                <a @if (!$has_ajax) href="{{ $paginator->url($paginator->currentPage() - 1) }}"
                @else
                data-url="{{ $paginator->url($paginator->currentPage() - 1) }}"
                style="cursor: pointer;" @endif
                    class="text-decoration-none w-100 h-100 d-flex justify-content-center align-items-center {{ $class }}">
                    << </a>
            </li>
        @endif

        <?php
        $start = $paginator->currentPage() - 1; // show 3 pagination links before current
        $end = $paginator->currentPage() + 1; // show 3 pagination links after current
        if ($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        }
        if ($end >= $paginator->lastPage()) {
            $end = $paginator->lastPage();
        } // reset end to last page
        ?>

        @if ($start > 1)

            <li class="pagination__item">
                {{--                <a href="#">1</a> --}}
                <a class="page-link {{ $class }}"
                    @if (!$has_ajax) href="{{ $paginator->url(1) }}"
                @else
                data-url="{{ $paginator->url(1) }}"
                style="cursor: pointer;" @endif>{{ 1 }}</a>
            </li>
            @if ($paginator->currentPage() != 4)
                {{-- "Three Dots" Separator --}}
                <li class="pagination__item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
        @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="pagination__item {{ $paginator->currentPage() == $i ? ' page-current' : '' }}">
                <a class="page-link {{ $class }}"
                    @if (!$has_ajax) href="{{ $paginator->url($i) }}"
                @else
                data-url="{{ $paginator->url($i) }}"
                style="cursor: pointer;" @endif>{{ $i }}</a>
            </li>
        @endfor
        @if ($end < $paginator->lastPage())
            @if ($paginator->currentPage() + 3 != $paginator->lastPage())
                {{-- "Three Dots" Separator --}}
                <li class="pagination__item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
            <li class="pagination__item">
                <a class="page-link {{ $class }}"
                    @if (!$has_ajax) href="{{ $paginator->url($paginator->lastPage()) }}"
                    @else
                data-url="{{ $paginator->url($paginator->lastPage()) }}"
                style="cursor: pointer;" @endif>{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        <div class="dropup-center dropup choose-paginate me-1">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Chọn trang
            </button>
            <div class="dropdown-menu">
                <input type="number" class="form-control input-paginate me-1" value="">
                <button class="btn btn-success btn-go-paginate">
                    Đi
                </button>
            </div>
        </div>

        @if ($paginator->currentPage() != $paginator->lastPage())
            <li class="pagination__arrow pagination__item">
                <a 
                @if (!$has_ajax)
                href="{{ $paginator->url($paginator->currentPage() + 1) }}"
                @else
                data-url="{{ $paginator->url($paginator->currentPage() + 1) }}"
                style="cursor: pointer;" @endif
                class="text-decoration-none w-100 h-100 d-flex justify-content-center align-items-center {{ $class }}">
                    >>
                </a>
            </li>
        @endif
    </ul>
@endif
