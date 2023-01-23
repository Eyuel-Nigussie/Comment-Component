@if ($paginator->hasPages())
<ul class="flex justify-between">
    @if($paginator->onFirstPage())
    <li class="invisible bg-red cursor-pointer p-2 drop-shadow-md" wire:click="previousPage">Prev</li>
    @else
    <li class="bg-white cursor-pointer p-2 border drop-shadow-md" wire:click="previousPage">Prev</li>
    @endif
    
    {{-- pagination number --}}
    @foreach($elements as $element)
    <div class="flex">
        @if (is_array($element))
         @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-blue-500 text-white cursor-pointer" wire:click="gotoPage({{$page}})">{{$page}}</li>
            @else
            <li class="mx-2 w-10 px-2 py-1 text-center rounded border shadow bg-slate-900 text-white cursor-pointer" wire:click="gotoPage({{$page}})">{{$page}}</li>
            @endif
         @endforeach
        @endif
    </div>
    @endforeach
   


    @if($paginator->hasMorePages())
    <li class="bg-white cursor-pointer p-2 border drop-shadow-md cursor-pointer" wire:click="nextPage">Next</li>
    @else
     {{-- hidden from site --}}
    <li class="invisible bg-white cursor-pointer p-2 border drop-shadow-md cursor-pointer" wire:click="nextPage">Next</li>
    @endif



</ul>
@endif