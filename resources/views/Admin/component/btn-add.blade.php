<?php
$title = $title ?? '';
$class = $class ?? '';
$href  = $data_href = $href ?? '#';
if (strpos($class, 'has-link_modal') !== false) {
    $href = '#';
}
?>
@if($href)
    <!-- === button add desktop === -->
    <div class="justify-content-end disable-max-width-768 text-nowrap">
        <a href="{{ $href }}" data-href="{{ $data_href }}"
           class="btn btn-success btn-icon float-end {{ $class }}">
            <i data-feather='plus'></i>
            @if($title)
                <span>{{ $title }}</span>
            @endif
        </a>
    </div>
    <!-- === button add mobile === -->

    <a title="{{ $title }}" href="{{ $href }}" data-href="{{ $data_href }}" class="btn btn-relief-success btnAddMobile enable-max-width-768 waves-effect waves-float waves-light{{ $class }}">
        <i data-feather='plus'></i> {{ $title }}
    </a>



@endif
