@if ($paginator->hasPages())
    
    <ul class="flex justify-between">
            {{-- prev --}}
        @if ($paginator->onFirstPage())
             <button disabled>Prev</button>
        @else
            <button wire:click='previousPage'>Prev</button>
        @endif

            {{-- numbers --}}
        @foreach ($elements as $element)
            <div class="flex">
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button wire:click='gotoPage({{$page}})'>{{$page}}</button>
                        @else
                            <button wire:click='gotoPage({{$page}})'>{{$page}}</button> 
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
             {{-- next --}}
        @if ($paginator->hasMorePages())
            <button wire:click='nextPage'>Next</button>
        @else
        <button disabled>Next</button>
        @endif
    </ul>

@endif