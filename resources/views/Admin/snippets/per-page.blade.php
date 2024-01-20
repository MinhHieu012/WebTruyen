<div class="selectShowSetting" style="' . $style . '">
    <div class="selectShowSetting_text">Hiển thị</div>
    <label class="selectShowSetting_select">
        <select onchange="tich_diem.setting_per_page(this)"
                data-name="{{ $name }}"
                data-url="{{ route('admin.settings.per_page.store') }}">
            @foreach($items as $item)
                <option value="{{$item}}" {{ $item == $item_default ? 'selected' : '' }}>
                    {{ $item }}
                </option>
            @endforeach
        </select>
    </label>
</div>
