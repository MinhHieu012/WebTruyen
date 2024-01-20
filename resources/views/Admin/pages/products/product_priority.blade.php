@php
use \Illuminate\Support\Carbon;
$current_date = Carbon::now()->format('Y-m-d');
@endphp
@extends('Admin.layouts.main')
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="padding-bottom:12px;">
                    <!-- === START: SEARCH === -->
                    <form class="row align-items-top" action="{{ route('admin.products.index') }} " method="get">
                        <div class="col-md-4 col-12">
                            <select class="form-control has-select2" data-placeholder="Chọn chu kỳ" name="search[period][]" multiple="multiple">
                                <option value="">Tất cả</option>
                                @if(isset($formOptions['period_options']) && is_array($formOptions['period_options']))
                                    @foreach($formOptions['period_options'] as $item)
                                        @if($item['started_at'] <= $current_date && $current_date <= $item['ended_at'])
                                            <option value="{{ $item['started_at'] }}" selected>{{ $item['name'] }}</option>
                                        @else
                                            <option value="{{ $item['started_at'] }}">{{ $item['name'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </form>
                    <!-- === END: SEARCH === -->

                    <!-- === START: MESSAGES === -->
                    @include('Admin.snippets.messages')
                    <!-- === END: MESSAGES === -->
                </div>

                <div class="table-responsive">
                    <table id="tableProducts" class="table table-bordered table-striped overflow-hidden">
                        <thead>
                        <tr>
                            <th class="text-center" width="40px">STT</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">Nhóm</th>
                            <th class="text-center">Sản phẩm</th>
                            <th class="text-center">Chu kỳ</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- === START: Pagination === -->
                <div class="row" style="margin-top:25px;">
                    <div class="col-sm-12 d-flex justify-content-center">
                        {{ !empty($results) ? $results->withQueryString()->links() : '' }}
                    </div>
                </div>
                <!-- === END: Pagination === -->

            </div>
        </div>
    </div>
@endsection
