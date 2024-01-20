@if (session()->has('messages'))
    @php
        $messages = session()->get('messages');
    @endphp
    <div
        class="alert alert-{{ $messages['type'] == 'success' ? 'success' : 'danger' }} fade show"
        role="alert">
        <div class="alert-body">
            {{ $messages['content'] }}
        </div>
    </div>
    @php
        session()->forget('messages');
    @endphp
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 pt-1 pb-1">
            @foreach ($errors->all() as $error)
                <li style="{{ !$loop->last ? 'margin-bottom: 5px;' : '' }}">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
