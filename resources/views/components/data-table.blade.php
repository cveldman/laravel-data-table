<div class="mb-4">
    <form>
        <label for="search" class="sr-only">Search</label>
        <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" aria-hidden="true">
                <!-- Heroicon name: solid/search -->
                <svg class="mr-3 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>

            <input type="text" name="search" value="{{ request()->input('search') }}" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 sm:text-sm border-gray-300 rounded-md" placeholder="Search"/>
        </div>
    </form>
</div>

<x-table :columns="$columns">
    {{ $slot }}
</x-table>

<div class="mt-4">
    {{ $paginator->appends(request()->all())->links() }}
</div>