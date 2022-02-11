<div {{ $attributes }}>
    <div class="mb-4">
        @include('data-table::search')
    </div>

    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    {{ $columns }}
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $paginator->appends(request()->all())->links() }}
    </div>
</div>