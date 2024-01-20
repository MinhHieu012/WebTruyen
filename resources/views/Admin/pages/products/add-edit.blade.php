@extends('Admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <form class="has-provinces" method="post" action="{{ $formOptions['action'] }}">
                @csrf
                @if($product_id)
                    @method('put')
                @endif
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-code">Mã sản phẩm <span class="text-danger">(*)</span></label>
                        <input type="text" id="form-code" class="form-control" name="code" value="{{ $default_values['code'] }}" placeholder="Mã sản phẩm" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-name">Tên sản phẩm <span class="text-danger">(*)</span></label>
                        <input type="text" id="form-name" class="form-control" name="name" value="{{ $default_values['name'] }}" placeholder="Tên sản phẩm" required>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-display_name">Tên hiển thị</label>
                        <input type="text" id="form-display_name" class="form-control" name="display_name" value="{{ $default_values['display_name'] }}" placeholder="Tên hiển thị">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-parent_id">Sản phẩm gốc</label>
                        <select id="form-parent_id" class="form-control has-select2" name="parent_id">
                            <option value="0">-- Là chính nó --</option>
                            @foreach ($formOptions['root_products'] as $item)
                                <option value="{{ $item->id }}" {{ $item->id==$default_values['parent_id'] ? 'selected':'' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-company_id">Công ty <span class="text-danger">(*)</span></label>
                        <select id="form-company_id" class="form-control" name="company_id">
                            <option value="">-- Chọn một --</option>
                            @foreach ($companies as $key => $item)
                                <option value="{{ $key }}" {{ $key == $default_values['company_id'] ? 'selected':'' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-parent_id">Sản phẩm tính hợp đồng key</label>
                        <select id="form-key_id" class="form-control has-select2" name="key_id">
                            <option value="">-- Là chính nó --</option>
                            @foreach ($formOptions['root_products'] as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $default_values['key_id'] ? 'selected':'' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-users">BM/ ABM</label>
                        @if (!empty($product_user))
                            @php
                                $arr_user = [];
                            @endphp
                            @foreach ($product_user as $item)
                                @php
                                    array_push($arr_user, $item->id);
                                @endphp
                            @endforeach

                            <select id="form-users" class="has-select2 form-select" name="users[]" multiple>
                                @foreach ($all_users as $user)
                                    @if (in_array($user->id, $arr_user))
                                        <option value="{{ $user->id }}" selected>{{ $user->name .' - '. $user->email }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name .' - '. $user->email }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @else
                            <select id="form-users" class="has-select2 form-select" name="users[]" multiple>
                                @foreach ($all_users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name .' - '. $user->email }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-wholesale_price">Giá buôn <span class="text-danger">(*)</span></label>
                        <input type="number" id="form-wholesale_price" class="form-control" min="0" name="wholesale_price" value="{{ $default_values['wholesale_price'] }}"/>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-price">Giá khuyến nghị <span class="text-danger">(*)</span></label>
                        <input type="number" id="form-price" class="form-control" min="0" name="price" value="{{ $default_values['price'] }}"/>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-status">Trạng thái <span class="text-danger">(*)</span></label>
                        <select id="form-status" class="form-control" name="status">
                            @foreach($formOptions['status'] as $v => $n)
                                <option
                                    value="{{ $v }}" {{ $v === intval($default_values['status']) && isset($default_values['status']) ? 'selected' : '' }}>
                                    {{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-status">Điểm<span class="text-danger">(*)</span></label>
                        <input type="number" class="form-control" name="point" value="{{ $default_values['point'] }}"/>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-unit">Quy cách đóng gói<span class="text-danger">(*)</span></label>
                        <select id="form-unit" class="form-control" name="unit">
                            <option value="">-- Chọn --</option>
                            @foreach (\App\Models\Product::UNIT_TEXTS as $key => $item)
                                <option value="{{ $key }}" {{ $key == $default_values['unit'] ? 'selected':'' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="form-unit">Sản phẩm CRM</label>

                        <select id="form-key_id" class="form-control has-select2" name="crm_product_id">
                            <option value="">-- Chọn --</option>
                            @foreach ($formOptions['crm_products'] as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $default_values['crm_product_id'] ? 'selected':'' }}>
                                    {{ $item->code }} - {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="form-unit">Setting quét mã QR</label>

                        <select id="form-key_id" class="form-control has-select2" name="need_scan_code">
                            @foreach (\App\Models\Product::NEED_SCAN_CODE_TEXTS as $key => $text)
                                <option value="{{ $key }}" {{ $key == $default_values['need_scan_code'] ? 'selected':'' }}>
                                    {{ $text }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-label">
                            <label class="form-label me-1" for="form-unit">Sản phẩm cho đơn lẻ</label>
                            <input class="form-check-input" type="checkbox"
                                   name="product_retail"
                                {{ $default_values['product_retail'] == '2' ? 'checked':'' }}>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-12 mt-1">
                        <label class="form-label" for="form-desc">Mô tả</label>
                        <textarea name="desc" id="form-desc" class="form-control" rows="2">{{ $default_values['desc'] }}</textarea>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success me-1">
                        {{ $product_id ? 'Cập nhật' : 'Tạo mới' }}
                    </button>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-1"><i data-feather='rotate-ccw'></i> Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
