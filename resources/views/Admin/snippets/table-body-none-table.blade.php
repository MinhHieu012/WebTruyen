@if(!$empty)
    <div class="pb-1 d-flex pt-0 table-show-option {{ $nameTable }}-tso">
        <div class="align-items-center d-flex w-100 text-nowrap form-mobile-sm ps-0">
            @if($isPagination)
                Hiển thị
                <label class="ms-1">
                    <select class="form-control form-select form-mobile-sm change-paginate-table">
                        @foreach($optionPaginate as $option)
                            <option value="{{ $option }}"
                                    @if($optionPerPage == $option) selected @endif>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </label>

            @endif
            @stack('table-option-start')
        </div>
        <div class="d-flex align-items-center justify-content-end form-mobile-sm ms-auto table-show-info" style="min-width: 180px;">
            @if($isPagination)
                @php($totalRecord = $collections->total())
                @if($currentRow < $optionPerPage && $totalRow >= $optionPerPage)
                    Hiển thị {{ $currentRow }}/{{ number_format($totalRecord) }}
                @elseif($totalRow >= $optionPerPage)
                    Hiển thị {{ $optionPerPage }}/{{ number_format($totalRecord) }}
                @else
                    Hiển thị {{ number_format($totalRecord) }}
                @endif
            @else
                Hiển thị: {{ number_format( $totalRow ?: $collections->count()) }}
            @endif
        </div>
    </div>
    @stack('table-top')
    <div id="{{ $nameTable }}" class="{{ $nameTable }}">
        @foreach($collections as $item)
            <div class="row-item">
                @foreach($headers as $key => $attribute)
                    @if(is_array($item->$key ?? null))
                        @if(isset($item->$key['hidden']))
                            @continue
                        @endif

                        @if(in_array($key, $customColumns))
                            <div
                                {!! $item->$key['attribute'] !!} class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                {!! $item->$key['value'] ?? null  !!}
                            </div>
                        @else
                            <div
                                {!! $item->$key['attribute'] !!} class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                {!! $item->$key['value'] ?? null  !!}
                            </div>
                        @endif
                    @else
                        @if(in_array($key, $customColumns))
                            <div
                                class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                {!! $item->$key ?? $item[$key] ?? null  !!}
                            </div>
                        @else
                            <div
                                class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                {!! $item->$key ?? $item[$key] ?? null  !!}
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
    @if($isPagination)
        <div class="row">
            <div class="col-sm-12 mt-1 d-sm-flex justify-content-center">
                {{ $collections->appends(request()->query())->onEachSide(1)->links('Admin.snippets.custom-pagination-mobile') }}
            </div>
        </div>
    @endif
@else
    <div class="card-body text-center">
        <h3 class="mb-0">Không có dữ liệu</h3>
    </div>
@endif
