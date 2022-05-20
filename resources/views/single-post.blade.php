@extends('layouts.blog_layouts', ['title'   => $posts->judul_artikel ?? ''])

@section('content')
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Blog Details</h2>
          <ol>
            <li><a href="{{ url('') }}">Home</a></li>
            <li>{{ $posts->judul_artikel ?? '' }}</li>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Blog Details Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row g-5">

          <div class="col-lg-8">

            @if($posts == '')
             <h4 class="mb-4">Artikel tidak ditemukan</h4>
            @endif

            @if($countPost > 0)
            <article class="blog-details">

              <div class="post-img">
                <img src="{{ url('img/article/walpaper/'.$posts->walpaper) }}" class="w-100" style="height:500px">
              </div>

              <h2 class="title">{{ $posts->judul_artikel }}</h2>

              <div class="meta-top">
                <ul>
                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="{{ url('/user'.$posts->user->id.'') }}">{{ $posts->user->name }}</a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i><time datetime="2022-01-01">{{ date('d M Y', strtotime($posts->publish_date)) }}</time></li>
                    <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i>{{ $countComment }} Komentar</li>
                    <li class="d-flex align-items-center"><i class="bi bi-eye"></i> {{ $posts->views_count }} Dilihat</li>
                </ul>
              </div><!-- End meta top -->

              <div class="content">
                {!! $posts->content !!}
              </div><!-- End post content -->

              <div class="meta-bottom">
                <i class="bi bi-folder"></i>
                <ul class="cats">
                  <li><a href="{{ url('category/'.$posts->category->category_name) }}">{{ $posts->category->category_name }}</a></li>
                </ul>

                <i class="bi bi-tags"></i>
                <ul class="cats">
                  @for($i=0; $i < count($postTags); $i++)
                  <li><a href="{{ url('tag/'.$postTags[$i]) }}">{{ $postTags[$i] }}</a></li>
                  @endfor
                </ul>

                <i class="bi bi-heart"></i>
                <ul class="cats">
                  <li><a>{{ $posts->likes_count }} @if($hasLike > 0) Anda menyukai artikel ini @endif </a></li>
                </ul>


              </div><!-- End meta bottom -->

            </article><!-- End blog post -->

            @if(session()->has('successaction'))
              <div class="alert alert-success my-4">
                {{ session('successaction') }}
              </div>   
            @endif
            <div class="post-author d-flex align-items-center" id="info">
              <img src="{{ url('img/user/'.$posts->user->photo) }}" class="rounded-circle flex-shrink-0" height="100" width="100" alt="">
              <div>
                <h4><a href="{{ url('user/'.$posts->user->id) }}" style="color:#5670a0">{{ $posts->user->name }}</a></h4>
                <div class="social-links">
                  <a href="https://twitters.com/#"><i class="bi bi-twitter"></i></a>
                  <a href="https://facebook.com/#"><i class="bi bi-facebook"></i></a>
                  <a href="https://instagram.com/#"><i class="biu bi-instagram"></i></a>
                </div>
                <p>
                  <form action="{{ url('actionpost/'.$posts->article_id) }}" method="POST">
                    @csrf
                    @if(auth()->check())
                      @if(auth()->user()->id !== $posts->author_id)
                        @if($hasFollow == 0)
                          <button name="follow" class="btn btn-primary"><i class="fa fa-user-plus"></i> Follow</button>
                        @else 
                          <button name="unfollow" class="btn btn-danger"><i class="fa fa-user-plus"></i> UnFollow</button>
                        @endif
                      @endif
                    @endif
                    @if($hasLike == 0)
                      <button name="likepost" class="btn btn-primary my-1"><i class="fa fa-heart"></i> Like Post</button>
                    @else 
                      <button name="unlikepost" class="btn btn-danger my-1"><i class="fa fa-heart"></i> Unlike Post</button>
                    @endif
                  </form>
                </p>
              </div>
            </div><!-- End post author -->

            <div class="comments" id="komentar">
                @if(session()->has('errors'))
									<div class="alert alert-danger mt-2">
										@foreach($errors->all() as $error)
												{{ $error }}<br>
										@endforeach
									</div>   
								@endif
								
								@if(session()->has('success'))
									<div class="alert alert-success mt-2">
										{{ session('success') }}
									</div>   
								@endif

              <h4 class="comments-count">{{ $countComment }} Komentar</h4>

              {{-- <div id="comment-1" class="comment">
                <div class="d-flex">
                  <div class="comment-img"><img src="{{ url('herobiz/assets/img') }}/blog/comments-1.jpg" alt=""></div>
                  <div>
                    <h5><a href="">Georgia Reader</a> <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a></h5>
                    <time datetime="2020-01-01">01 Jan,2022</time>
                    <p>
                      Et rerum totam nisi. Molestiae vel quam dolorum vel voluptatem et et. Est ad aut sapiente quis molestiae est qui cum soluta.
                      Vero aut rerum vel. Rerum quos laboriosam placeat ex qui. Sint qui facilis et.
                    </p>
                  </div>
                </div>
              </div><!-- End comment #1 --> --}}

              @foreach($comments as $comment)
              <form method="POST" action="{{ url('/delete_komen/'.$comment->comment_id) }}">
              @csrf
              <div id="{{ $comment->comment_id }}" class="reply-form comment">
                <div class="d-flex">
                  <div class="comment-img"><img src="{{ url('img/user/'.$comment->user->photo) }}" alt="" style="height:70px;width:70px;"></div>
                  <div>
                    <h5>
                        <a href="">{{ $comment->user->name }}</a>
                        @if(auth()->check())
                          @if($comment->user_id == auth()->user()->id)
                          <button onclick="return confirm('Apakah anda yakin?')" class="btn btn" class="reply">
                            <i class="bi bi-trash"></i> Hapus
                          </button>
                          @endif
                        @endif
                    </h5>
                    <time datetime="2020-01-01" style="margin-top:-5px;" >{{ date('d F Y H:i:s', strtotime($comment->created_at)) }}</time>
                    <p>
                      {{ $comment->comment_value }}
                    </p>
                  </div>
                  </form>
                </div>

                @foreach($replyComment as $reply)
                  @if($reply->reply_comment_id == $comment->comment_id)
                  <form method="POST" action="{{ url('/delete_komen/'.$reply->comment_id) }}">
                    @csrf
                    <div id="comment-reply-1" class="comment comment-reply">
                      <div class="d-flex">
                        <div class="comment-img"><img src="{{ url('img/user/'.$reply->user->photo) }}" alt="" style="height:70px;width:70px;"></div>
                        <div>
                          <h5>
                            <a href="">{{ $reply->user->name }}</a>
                            @if(auth()->check())
                              @if($reply->user_id == auth()->user()->id)
                              <button onclick="return confirm('Apakah anda yakin?')" class="btn btn" class="reply">
                                <i class="bi bi-trash"></i> Hapus
                              </button>
                              @endif
                            @endif
                          </h5>
                          <time datetime="2020-01-01" style="margin-top:-5px;">{{ date('d F Y H:i:s', strtotime($reply->created_at)) }}</time>
                          <p>
                            {{ $reply->comment_value }}
                          </p>
                        </div>
                      </div>
                    </div><!-- End comment reply #1-->
                    </form>
                  @endif
                @endforeach
            
                <div class="my-4 comment-reply">
                  <h4>Tinggalkan komentar untuk "{{ $comment->comment_value }}"</h4>
                  <form action="{{ url('reply_komen/'.$comment->comment_id) }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col form-group">
                        <textarea name="reply" class="form-control" placeholder="Your Comment*"> {{ old('reply') }} </textarea>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Reply</button>
                  </form>
                </div>

              </div><!-- End comment #2-->
              @endforeach

              <div class="reply-form">

                <h4>Tinggalkan Komentar</h4>
                <form action="{{ url('komen_artikel/'.$posts->article_id) }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col form-group">
                      <textarea name="comment" class="form-control" placeholder="Your Comment*">{{ old('comment') }}</textarea>
                    </div>
                  </div>
                  <button type="submit" id="postcomment" class="btn btn-primary">Post Comment</button>

                </form>

              </div>

            </div><!-- End blog comments -->
            @endif

          </div>

            @include('layouts.sidebar')
        </div>

      </div>
    </section><!-- End Blog Details Section -->

  </main><!-- End #main -->
  @endsection
  
  @section('meta')
    <meta content="{{ substr(strip_tags($posts->content ?? ''),0,250) }}" name="description">
    <meta content="{{ $posts->tags ?? '' }}" name="keywords">
    <meta property="og:url" content="{{ webInfo('URL_WEB') }}" />
    <meta property="og:title" content="{{ $posts->judul_artikel ?? '' }} />
    <meta property="og:description" content="{{ substr(strip_tags($posts->content ?? ''),0,250) }}" />
    <meta property="og:site_name" content="{{ webInfo("JUDUL_WEB") }}" />
    <meta property="og:type" content="website" />
  @endsection