@foreach( $items as $menu_item )
    @if( !empty($menu_item['route']) && $menu_item['route'] == 'logout' )
        <li class="nav-item">
            <form method="post" action="{{ $menu_item['href'] }}" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-icon d-flex align-items-center">
                    <i data-feather="log-out"></i>
                    <span class="menu-title text-truncate">{{ $menu_item['name'] }}</span>
                </button>
            </form>
        </li>
    @else
        <li class="nav-item {{ $menu_item['active'] ? 'active' : '' }} {{ !empty($menu_item['child']) ? 'has-sub' : '' }}
        {{ $item['class'] ?? '' }}">
            <a class="d-flex align-items-center" href="{{ $menu_item['href'] ?? '#' }}">
                {!! isset($sub) ? '<i data-feather="circle"></i>' : ($menu_item['icon'] ?? '') !!}
                <span class="menu-title text-truncate">{!! $menu_item['name'] !!}</span>
            </a>
            @if( !empty( $menu_item['child'] ) )
                <ul class="menu-content">
                    @include('Admin.snippets.menu-items', ['items' => $menu_item['child'], 'sub'=> true])
                </ul>
            @endif
        </li>
    @endif
@endforeach
