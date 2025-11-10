@foreach ($articles as $article)
    <div class="col-lg-4">
        <div class="article">
            <div class="img-container">
                <img alt="article img" src="{{ displayFile($article->image) }}">
            </div>
            <div class="content">
                <span>
                    <i class="fa fa-calendar-week"></i>
                    {{ $article->created_at->diffForHumans() }}
                </span>

                <h5>{{ $article->title }}</h5>
                <div class="desc">
                    <p>{{ $article->short_body }}</p>
                </div>
                <a href="{{ route('website.articles.show', $article) }}">
                    {{ __kw('show_more', 'عرض المزيد') }}
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
