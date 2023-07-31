@if($paginator->hasPages())
    <ul class="pagination pagination-rounded justify-content-center mt-4">
        @if($paginator->onFirstPage())
            <li class="page-item disabled"><a href="javascript:;" class="page-link"><span>Prev</span></a></li>
        @else
            <li class="page-item"><a href="javascript:;" wire:click="previousPage" rel="prev" class="page-link"><span>Prev</span></a></li>
        @endif
        
        @foreach($elements as $element)
            @if(is_string($element))
                <li class="page-item disabled"><a class="page-link"><span>{{$element}}</span></a></li>
            @endif

            @if(is_array($element))
                @foreach($element as $page=>$url)
                    @if($page==$paginator->currentPage())
                        <li class="page-item active" aria-current="page"><a href="javascript:;" wire:click="gotoPage({{$page}})" class="page-link"><span>{{$page}}</span></a></li>
                    @else
                        <li class="page-item"><a href="javascript:;" wire:click="gotoPage({{$page}})" class="page-link"><span>{{$page}}</span></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <li class="page-item"><a href="javascript:;" wire:click="nextPage" rel="next" class="page-link"><span>Next</span></a></li>
        @else
            <li class="page-item disabled"><a href="javascript:;" class="page-link"><span>Next</span></a></li>
        @endif
    </ul>
@endif