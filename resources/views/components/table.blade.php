@props(['headers' => [], 'rows' => []])

<table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
    <thead>
        <tr>
            @foreach($headers as $header)
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    {{ $header['label'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($rows as $row)
            <tr>
                @foreach($headers as $header)
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(isset(${'cell_'.$header['key']}))
                            {{ ${'cell_'.$header['key']}($row) }}
                        @else
                            {{ $row->{$header['key']} }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
