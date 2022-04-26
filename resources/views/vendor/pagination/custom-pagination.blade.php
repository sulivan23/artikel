
@if ($paginator->hasPages())
    <ul class="justify-content-center">
       
        @if ($paginator->onFirstPage())
            <li class="disabled"><a>←</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a>{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">→</a></li>
        @else
            <li class="disabled"><a>→</a></li>
        @endif
    </ul>
@endif 