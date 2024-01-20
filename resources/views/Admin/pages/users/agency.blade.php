<div class="wrapper_has_agency" style="display: none;">
    <div class="form-check mt-1">
        <input class="form-check-input checkbox-show-option"
               type="checkbox" id="user-{{ $user_id }}-has_agency"
               name="has_agency"
               value="1" {{ $default_values['has_agency'] ? 'checked' : '' }}
               data-wrapper=".wrapper-has_agency">
        <label class="form-check-label" for="user-{{ $user_id }}-has_agency">
            Liên kết đại lý</label>
    </div>
    <div class="mt-1 wrapper-has_agency"
         style="{{ !$default_values['has_agency'] ? 'display:none;' : '' }}">
        <input type="hidden" name="old_agency_id" value="{{ $default_values['agency_id'] }}">
        <select id="user_agency_id" name="agency_id" class="form-control has-select2">
            <option value="">- Đại lý -</option>
            @foreach($formOptions['agencies'] as $agencyId => $agencyName)
                <option value="{{ $agencyId }}"
                    {{ $default_values['agency_id'] == $agencyId ? 'selected' : '' }}>
                    {{ $agencyName }}</option>
            @endforeach
        </select>
    </div>
</div>
