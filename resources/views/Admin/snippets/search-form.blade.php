<?php

use App\Helpers\SearchFormHelper;

$idFormSearch = now()->timestamp
?>
<form class="row component-search-form w-100 {{ $class }}" {{ $attributes }} action="{{ $route }}" id="search-form"
      method="{{ $method }}">
    @foreach($config as $input)
        <div
            class="{{ $input['wrapClass'] ?? 'col-md-auto' }} mb-1 p-0 ms-1 component-search-input {{--{{ ($input['class'] ?? '') }}--}}">
            {!!
                SearchFormHelper::getInput(
                    $input['type'] ?? '',
                    $input['name'] ?? '',
                    $input['placeholder'] ?? '',
                    $input['defaultValue'] ?? '',
                    ($input['class'] ?? ''),
                    $input['id'] ?? '',
                    $input['options'] ?? [],
                    $input['attributes'] ?? '',
                    $input['divisionPickerConfig'] ?? [],
                    $input['other_options'] ?? [],
                    $input['yearMonthWeekConfig'] ?? [],
                )
            !!}
        </div>
    @endforeach
    <label class="col-auto mb-1 p-0 ms-1 wrap-button-search">
        <button class="btn btn-primary btn-icon" type="submit">
            <i data-feather="search"></i>
            Tìm kiếm
        </button>
{{--        @if(request()->route()->getName() == 'admin.tdv.store.index')--}}
{{--            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="modal"--}}
{{--                    data-bs-target="#store-advanced-search">--}}
{{--                Nâng cao--}}
{{--            </button>--}}
{{--        @endif--}}
    </label>
        @if($clearFilter)
            <label id="btn-reset-filter" class="col-auto mb-1 pe-0 text-black" style="height: 36px; display: none">
                <a href="{{$route}}" class="btn btn-icon btn-outline-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-360" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M17 15.328c2.414 -.718 4 -1.94 4 -3.328c0 -2.21 -4.03 -4 -9 -4s-9 1.79 -9 4s4.03 4 9 4" />
                        <path d="M9 13l3 3l-3 3" />
                    </svg>
                    Bỏ bộ lọc
                </a>
            </label>
        @endif
    @can($permissionExport)
        <label class="col-auto mb-1">
            <button type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modal_export_{{$idFormSearch}}"
                    data-href="{{ route($routeExport, array_merge(
                        [
                            'totalRecord' => $totalRecordExport,
                            'hash_id' => request('search.hash_id') ?: md5('505_' . time())
                        ],
                        request()->all(),
                        ))
                }}"
                    class="btn btn-icon btn-outline-dark export-js">
                <i data-feather='download'></i>
                {{$label ? $label : 'Export'}}
            </button>
        </label>
    @endcan
{{--    @yield('optionInsert')--}}
    @stack('optionInsert')
</form>
@can($permissionExport)
    @include('Admin.snippets.modal-export-progress', ['idExportModal' => "modal_export_$idFormSearch"])
@endcan
@push('scripts-custom')
    <script defer>
        const urlParams = new URLSearchParams(window.location.search);
        let searchParam = []
        urlParams.forEach((value, key) => {
            searchParam.push(key)
        });
        if (searchParam.length > 0){
            $('#btn-reset-filter').show()
        }
    </script>
@endpush
{{--@if(request()->route()->getName() == 'admin.tdv.store.index')--}}
{{--    @include('Admin.snippets.modal-store-advanced-search', [--}}
{{--                        'numberDayNotOrder' => request('search.number_day_not_order') ?? null,--}}
{{--                        'notEnoughVisit' => request('search.not_enough_visit') ?? null])--}}
{{--@endif--}}
