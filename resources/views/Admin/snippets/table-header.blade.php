<tr>
    <?php
        $orderBys = request('options.orderBy', []);
        $orderTypes = [];
        $classTypes = [];
        foreach ($orderBys as $orderBy) {
            if (isset($orderBy['column']) && isset($orderBy['type'])) {
                $orderTypes[$orderBy['column']] = $orderBy['type'];
                if ($orderBy['type'] == "ASC") {
                    $classTypes[$orderBy['column']] = "column-order-asc";
                }
                if ($orderBy['type'] == "DESC") {
                    $classTypes[$orderBy['column']] = "column-order-desc";
                }
            }
        }
    ?>
    @foreach($headers as $key => $header)
    <th @if(in_array($key, $sortColumn))
            class="align-middle table-column-sorting  {{ $classTypes[$key] ?? '' }} {{ $classCustom[$key] ?? '' }} text-center text-nowrap" style="{{ $styleCss[$key] ?? '' }}" data-sort-key="{{ $key }}" data-sort-type="{{ $orderTypes[$key] ?? '' }}"
        @else
            class="{{ $classCustom[$key] ?? '' }} text-center text-nowrap align-middle" style="{{ $styleCss[$key] ?? '' }}"
        @endif
    >
        @if(in_array($key, $customColumn))
            {!! $header !!}
        @else
            {!! $header !!}
        @endif
    </th>
    @endforeach
</tr>
