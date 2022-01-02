    <article>
        <h1>
            <a href="/posts/{{$post->id}}">
                {!!$post->title!!}
            </a>
        </h1>
        <div>{{ $post->excerpt }}</div>
    </article>