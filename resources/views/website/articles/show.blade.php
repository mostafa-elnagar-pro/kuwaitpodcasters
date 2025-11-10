<x-website.layout>

    <div class="main">
        <div class="barcrumb">
            <h1>{{ $article->name }}</h1>
            <div>
                <a href="{{ route('website.index') }}">{{ __kw('home', 'الرئيسية') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <a href="{{ route('website.articles.index') }}">{{ __kw('articles_news', 'الاخبار و المقالات') }}</a>
                <i class="fa-solid fa-chevron-left"></i>
                <span>{{ $article->title }}</span>
            </div>
        </div>
        <div class="container arcicle-details">
            <div class="row py-5">
                <div class="col-lg-7 details">
                    <img src="{{ displayFile($article->image) }}">
                    <div class="content">
                        <h3>{{ $article->title }}</h3>
                        <p>{!! $article->body !!}</p>
                    </div>
                </div>
                <div class="col-lg-5 px-4">
                    <h3>{{ __kw('other_articles', 'مقالات أخري') }}</h3>
                    @foreach ($other_articles as $article)
                        <a href="{{ route('website.articles.show', $article) }}" class="breif-article">
                            <img alt="article" src="{{ displayFile($article->image) }}">
                            <div>
                                <p>{{ $article->title }}</p>
                                <span>{{ $article->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




</x-website.layout>
