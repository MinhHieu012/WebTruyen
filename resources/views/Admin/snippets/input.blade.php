@switch($type)
    @case("hidden")
        <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $defaultValue }}">
        @break
    @case("text")
        <input type="text"
               class="form-control {{ $class }}"
               id="{{ $id }}"
               placeholder="{{ $placeholder }}"
               name="{{ $name }}"
               value="{{ $defaultValue }}"
            {{ $attributes }}
        >
        @break
    @case("number")
        <input type="number"
               class="form-control {{ $class }}"
               id="{{ $id }}"
               placeholder="{{ $placeholder }}"
               name="{{ $name }}"
               value="{{ $defaultValue }}"
            {{ $attributes }}
        >
        @break
    @case("password")
        <input type="password" {{ $attributes }}
        class="form-control {{ $class }}"
               id="{{ $id }}"
               placeholder="{{ $placeholder }}"
               name="{{ $name }}"
               value="{{ $defaultValue }}"
        >
        @break
    @case("selection")
        @if($placeholder)
            <label class="form-check-label" for="{{ $id }}">{{ $placeholder }}</label>
        @endif
        <select id="{{ $id }}" class="form-control form-select {{ $class }}" name="{{ $name }}" {!! $attributes !!}>
            @foreach($options as $key => $option)
                <option value="{{ $key }}"
                        {!! is_array($option) ? ($option['attributes'] ?? '') : '' !!}
                        class="{{ ($other_options['option_class'] ?? '') }}"
                        @if($key == $defaultValue) selected @endif>
                    {{ is_array($option) ? ($option['name'] ?? '-') : $option }}
                </option>
            @endforeach
        </select>
        @break
    @case("select2")
        <select id='{{ $id }}' {!! $attributes !!}
        class='form-control has-select2 form-select {{$class}}'
                name='{{ $name }}'
        >
            @foreach($options as $key => $option)
                <option value="{{ $key }}"
                        {!! is_array($option) ? ($option['attributes'] ?? '') : '' !!}
                        class="{{ ($other_options['option_class'] ?? '') }}"
                        @if($key == $defaultValue) selected @endif>
                    {{ is_array($option) ? ($option['name'] ?? '-') : $option }}
                </option>
            @endforeach
        </select>
        @break
    @case("multipleSelect2")
        <select id='{{ $id }}' {!! $attributes  !!}
        class='form-control has-select2 form-select {{ $class }}' style="width: unset !important;"
                name='{{ $name }}'
                multiple
                data-placeholder="{{ $placeholder }}"
        >
            @foreach($options as $key => $option)
                <option value="{{ $key }}" class="{{ ($other_options['option_class'] ?? '') }}"
                        @if(in_array($key, $defaultValue)) selected @endif>{{ $option }}</option>
            @endforeach
        </select>
        @break
    @case("checkbox")
        <label class="d-flex align-items-center h-100">
            <input class="form-check-input"
                   @if(isset($defaultValue) && $defaultValue) checked @endif type="checkbox" id="{{ $id }}"
                   name="{{ $name }}" {{ $attributes }}>
            <label class="form-check-label text-nowrap ms-1" for="{{ $id }}">{{ $placeholder }}</label>
        </label>
        @break
    @case("radio")
        <input class="form-check-input {{ $class }}" type="radio" id="{{ $id }}" name="{{ $name }}" {{ $attributes }}>
        <label class="form-check-label" for="{{ $id }}">{{ $placeholder }}</label>
        @break
    @case("radios")
        @foreach($options as $key => $value)
            <div class="form-check {{ !$loop->last ? 'mb-25' : '' }} {{ $class }}">
                <input class="form-check-input" type="radio" name="{{ $name }}"
                       id="{{ $name }}-{{ $key }}" value="{{ $key }}"
                    {{ ($defaultValue ?? '') == $key ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $name }}-{{ $key }}">{{ $value }}</label>
            </div>
        @endforeach
        @break
    @case("datepicker")
        <input type="text" name="{{ $name }}" {{ $attributes }} id="{{ $id }}"
               class="form-control flatpickr-basic flatpickr-input"
               placeholder="@if(isset($placeholder)) {{ $placeholder }} @else YYYY-MM-DD @endif"
               value="{{ $defaultValue }}"
               readonly="readonly">
        @break
{{--    @case("dateRangePicker")--}}
{{--        <input type="text" id="{{ $id }}" name="{{ $name }}" {{ $attributes }}--}}
{{--        class="form-control flatpickr-range flatpickr-input {{ $class }}"--}}
{{--               placeholder="@if(isset($placeholder)) {{ $placeholder }} @else YYYY-MM-DD to YYYY-MM-DD @endif"--}}
{{--               value="{{ $defaultValue }}"--}}
{{--               readonly="readonly">--}}
{{--        @break--}}
{{--    @case("v2DateRangePicker")--}}
    @case("dateRangePicker")

        <input type="text" id="{{ $id }}" name="{{ $name }}" {!! $attributes !!}
        class="form-control daterangepicker_v2 {{ $class }}"
               placeholder="@if(isset($placeholder)) {{ $placeholder }} @else YYYY-MM-DD to YYYY-MM-DD @endif"
               value="{{ $defaultValue }}">
        @break
    @case("divisionPicker")
        @php $widthDefault = $divisionPickerConfig['widthDefault'] ?? '300px'@endphp

        <div style="min-width: {!! $widthDefault !!}" class="{{$class}}">
            {!!
                \App\Helpers\Helper::getTreeOrganization(
                    $divisionPickerConfig['currentUser'] ?? null,
                    $divisionPickerConfig['activeTypes'] ?? [],
                    $divisionPickerConfig['excludeTypes'] ?? [],
                    $divisionPickerConfig['hasRelationship'] ?? false,
                    $divisionPickerConfig['setup'] ?? [
                        'multiple'   => false,
                        'name'       => '',
                        'class'      => '',
                        'id'         => '',
                        'attributes' => '',
                        'selected'   => null,
                        'placeholder' => null
                    ]
                )
            !!}
        </div>
        @break
    @case("selectionYearMonthWeek")
        <div class="row">
            @if(isset($yearMonthWeekConfig))
                @foreach($yearMonthWeekConfig as $el)
                    <div class="{{ $el['class'] ?? '' }}">
                        @if(isset($el['placeholder']))
                            <label class="form-check-label" for="{{ $el['id'] }}">{{ $el['placeholder'] }}</label>
                        @endif
                        <select id="{{ $el['id'] }}" class="form-control form-select"
                                name="{{ $el['name'] }}" {!! $el['attributes'] ?? null !!}>
                            @foreach($el['options'] as $key => $option)
                                <option value="{{ $key }}"
                                        {!! is_array($option) ? ($option['attributes'] ?? '') : '' !!}
                                        class="{{ ($other_options['option_class'] ?? '') }}"
                                        @if($key == $el['defaultValue']) selected @endif>
                                    {{ is_array($option) ? ($option['name'] ?? '-') : $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            @endif
        </div>
        @break
@endswitch
