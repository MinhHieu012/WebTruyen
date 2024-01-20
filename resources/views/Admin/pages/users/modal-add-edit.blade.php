<div class="modal modal-slide-in new-user-modal fade" id="{{ $modal_id }}">
    <div class="modal-dialog">
        <form class="form-update-user modal-content pt-0" method="post"
              action="{{ $formOptions['action'] }}">
            @csrf
            @if($user_id)
                @method('put')
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ $modal_title }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="modal-alert"></div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-name-{{ $user_id }}">Họ và tên</label>
                    <input type="text" id="basic-icon-default-name-{{ $user_id }}"
                           class="form-control"
                           name="name"
                           value="{{ $default_values['name'] }}" required/>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-name-{{ $user_id }}">Tài khoản</label>
                    <input type="text" id="basic-icon-default-name-{{ $user_id }}"
                           class="form-control"
                           name="username"
                           value="{{ $default_values['username'] }}" required/>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-position-{{ $user_id }}">Vị trí làm việc</label>
                    <input type="text" id="basic-icon-default-position-{{ $user_id }}"
                           class="form-control"
                           name="position"
                           value="{{ $default_values['position'] }}"/>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="user-{{ $user_id }}-default-email">Email</label>
                    <input type="text" id="user-{{ $user_id }}-default-email"
                           class="form-control"
                           name="email"
                           value="{{ $default_values['email'] }}" required/>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="user-{{ $user_id }}-default-password">Mật khẩu</label>
                    <input type="password"
                           id="user-{{ $user_id }}-default-password"
                           class="form-control"
                           name="password"
                           value=""
                           min="8" {{ $user_id ? '' : 'required' }}/>
                </div>
                <div class="mb-1">
                    <label class="form-label" for="user-{{ $user_id }}-role">Vai trò</label>
                    <select id="user-{{ $user_id }}-role" class="has-select2 form-select" name="roles[]" multiple>
                        @foreach( $formOptions['roles'] as $role )
                            <option
                                value="{{ $role->id }}" {{ in_array($role->id, $default_values['roles']) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="user-{{ $user_id }}-plan">Trạng thái</label>
                    <select id="user-{{ $user_id }}-plan" class="has-select2 form-select" name="status">
                        @foreach( $formOptions['status'] as $v => $n )
                            <option
                                value="{{ $v }}" {{ $v === $default_values['status'] ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="user-{{ $user_id }}-change_password"
                               name="change_pass"
                               value="1" {{ $default_values['change_pass'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="user-{{ $user_id }}-change_password">Đổi mật khẩu</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success me-1" onclick="tich_diem.user_validate(this)">
                    {{ $user_id ? 'Cập nhật' : 'Tạo mới' }}
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>
