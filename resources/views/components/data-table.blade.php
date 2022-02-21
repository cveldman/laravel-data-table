<div {{ $attributes }}>
    <div class="mb-4">
        @include('data-table::search')
    </div>

    <!-- <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"> -->
    <div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                @if(is_array($columns))
                    @foreach($columns as $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __($column) }}
                        </th>
                    @endforeach
                @else
                    <tr>
                        {{ $columns }}
                    </tr>
                @endif
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $datatable->appends(request()->all())->links() }}
    </div>
</div>