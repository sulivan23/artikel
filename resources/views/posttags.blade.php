  
  @extends('layouts.blog_layouts', ['title' => 'Home Page'])
  
  @section('content')
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Blog</h2>
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li>Post By Tags</li>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row g-5">

          <div class="col-lg-8">
            
            <h4 class="mb-4">{{ $message }}</h4>
            @if($title !== null)
              <h4 class="mb-4">{{ $message2 }}</h4>
            @endif
            <div class="row gy-4 posts-list">

              @foreach($posts as $article)
              <div class="col-lg-6">
                <article class="d-flex flex-column">

                  <div class="post-img">
                    <img src="{{ url('img/article/walpaper/'.$article->walpaper) }}" alt="" class="w-100 h-100">
                  </div>

                  <h2 class="title">
                    <a href="{{ url('/'.$article->slug) }}">{{ $article->judul_artikel }}</a>
                  </h2>

                  <div class="meta-top">
                    <ul>
                      <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="{{ url('/user'.$article->user->id.'') }}">{{ $article->user->name }}</a></li>
                      <li class="d-flex align-items-center"><i class="bi bi-clock"></i><time datetime="2022-01-01">{{ date('d M Y', strtotime($article->publish_date)) }}</time></li>
                      <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i>0 Comments</li>
                    </ul>
                  </div>

                  <div class="content">
                    <p>
                      @php 
                        $content = preg_replace("/<img[^>]+\>/i", " ", $article->content); 
                      @endphp
                      @if(strlen($content) > 150)
                        {!! substr($content,0,150)."...." !!}
                      @else 
                        {!! $content !!}
                      @endif
                    </p>
                  </div>

                  <div class="read-more mt-auto align-self-end">
                    <a href="{{ url('/'.$article->slug) }}">Read More</a>
                  </div>

                </article>
              </div><!-- End post list item -->
              @endforeach
            </div><!-- End blog posts list -->

            {{-- <div class="blog-pagination">
              <ul class="justify-content-center">
                <li><a href="#">1</a></li>
                <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
              </ul>
            </div><!-- End blog pagination --> --}}

            <div class="blog-pagination">
              {!! $posts->links('vendor.pagination.custom-pagination') !!}
            </div>

            @if($posts->count() == 0)
                <p class="text-center">Artikel tidak ditemukan</p>
            @endif

          </div>

        @include('layouts.sidebar')

        </div>

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->
  @endsection