 <div class="col-lg-4">

    <div class="sidebar">

        <div class="sidebar-item search-form">
        <h3 class="sidebar-title">Search</h3>
        <form action="" class="mt-3">
            <input name="title" type="text">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>
        </div><!-- End sidebar search formn-->

        <div class="sidebar-item categories">
        <h3 class="sidebar-title">Categories</h3>
        <ul class="mt-3">
            @foreach($category as $cat)
            <li><a href="{{ url('category/'.$cat->category_name) }}">{{ $cat->category_name }} <span>({{ $cat->jml }})</span></a></li>
            @endforeach
        </ul>
        @if($category->count() == 0)
            <p>Belum ada kategori terbaru</p>
        @endif
        </div><!-- End sidebar categories-->

        <div class="sidebar-item recent-posts">
        <h3 class="sidebar-title">Popular Posts</h3>

        <div class="mt-3">

            @foreach($recentPost as $recent)
            <div class="post-item mt-3">
            <img src="{{ url('img/article/walpaper/'.$recent->walpaper) }}" alt="" class="flex-shrink-0" style="height:80px;">
            <div>
                <h4><a href="{{ url('/'.$recent->slug) }}">{{ $recent->judul_artikel }}</a></h4>
                <time datetime="2020-01-01">{{ date('d F Y', strtotime($recent->publish_date)) }}</time>
                <time datetime="2020-01-01"><i class="bi bi-eye"></i> {{ $recent->views_count }} Dilihat</time>
            </div>
            </div><!-- End recent post item-->
            @endforeach

            @if($recentPost->count() == 0)
            <p>Belum ada post terbaru</p>
            @endif

        </div>

        </div><!-- End sidebar recent posts-->

        <div class="sidebar-item tags">
        <h3 class="sidebar-title">Tags</h3>
        <ul class="mt-3">
        @if($tags !== "")
            @php 
            $allTags = explode(',', $tags);
            @endphp
            @for($i = 0; $i < count($allTags); $i++)
            <li><a href="{{ url('tag/'.$allTags[$i]) }}">{{ $allTags[$i] }}</a></li>
            @endfor
        @else 
            <p>Belum ada tags terbaru</p>
        @endif
        </ul>
        </div><!-- End sidebar tags-->

    </div><!-- End Blog Sidebar -->

    </div>