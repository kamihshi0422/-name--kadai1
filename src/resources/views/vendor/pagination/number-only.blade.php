@if ($contacts->hasPages())
    <nav class="pagination mt-4">
        <ul class="inline-flex items-center space-x-2">
            {{-- 前ページリンク --}}
            @if ($contacts->onFirstPage())
                <li><span class="px-2 py-1 text-gray-400">&lt;</span></li>
            @else
                <li><a href="{{ $contacts->previousPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">&lt;</a></li>
            @endif

            {{-- ページ番号 --}}
            @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                <li>
                    @if ($contacts->currentPage() == $i)
                        <span class="px-2 py-1 current">{{ $i }}</span>
                    @else
                        <a href="{{ $contacts->url($i) }}" class="px-2 py-1 border rounded hover:bg-gray-200">{{ $i }}</a>
                    @endif

                </li>
            @endfor

            {{-- 次ページリンク --}}
            @if ($contacts->hasMorePages())
                <li><a href="{{ $contacts->nextPageUrl() }}" class="px-2 py-1 border rounded hover:bg-gray-200">&gt;</a></li>
            @else
                <li><span class="px-2 py-1 text-gray-400">&gt;</span></li>
            @endif
        </ul>
    </nav>
@endif
