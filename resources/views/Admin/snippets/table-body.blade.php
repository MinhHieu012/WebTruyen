@if(!$empty)
    <div class="pb-1 d-flex pt-0 table-show-option">
        <div class="align-items-center d-flex w-100 text-nowrap form-mobile-sm ps-0">
            @if($isPagination)
                Hiển thị
                <label class="ms-1">
                    <select class="form-control form-select form-mobile-sm change-paginate-table">
                        @foreach($optionPaginate as $option)
                            <option value="{{ $option }}"
                                    @if(request('options.perPage', config('table.default_paginate')) == $option) selected @endif>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </label>

            @endif
            @stack('table-option-start')
        </div>
        <div class="d-flex align-items-center justify-content-end form-mobile-sm ms-auto" style="min-width: 180px;">
            @if($isPagination)
                @php($perPage = request('options.perPage', config('table.default_paginate')))
                @php($totalRecord = $collections->total())
                @if($collections->total() >= $perPage)
                    Hiển thị {{ $perPage }}/{{ number_format($totalRecord) }}
                @else
                    Hiển thị {{ number_format($totalRecord) }}
                @endif
            @else
                @if ($showCount)
                    Hiển thị: {{ number_format( $totalRow ?: $collections->count()) }}
                @endif
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table id="{{ $nameTable }}" class="table table-sm dataTable table-bordered dataTable">
            <thead class="table-light">
            {!! $headerHtml !!}
            </thead>
            <tbody>
            @foreach($collections as $item)
                <tr>
                    @foreach($headers as $key => $attribute)
                        @if(is_array($item->$key ?? null))
                            @if(isset($item->$key['hidden']))
                                @continue
                            @endif

                            @if(in_array($key, $customColumns))
                                <td {!! $item->$key['attribute'] !!} class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                    {!! $item->$key['value'] ?? null  !!}
                                </td>
                            @else
                                <td {!! $item->$key['attribute'] !!} class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                    {!! $item->$key['value'] ?? null  !!}
                                </td>
                            @endif
                        @else
                            @if(in_array($key, $customColumns))
                                <td class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                    {!! $item->$key ?? null  !!}
                                </td>
                            @else
                                <td class="{{ $classCustom[$key] ?? (in_array($key, $centreColumn) ? 'text-center' : '') }}">
                                    {!! $item->$key ?? null  !!}
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
            @if($footerRow)
                <tfoot>
                {!! $footerRow !!}
                </tfoot>
            @endif
        </table>
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
