@foreach ($categories as $category)
    <div class="col-sm-4 col-lg-3 p-5">
        <a href="{{ route('website.categories.show', $category) }}" class="category d-flex flex-column align-items-center gap-4">
            <img alt="cat" src="{{ displayFile($category->image) }}" width="100px">
            <h3>{{ $category->name }}</h3>
        </a>
    </div>
@endforeach
