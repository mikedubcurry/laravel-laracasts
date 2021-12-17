<x-layout>
    @foreach ($posts as $post)
        <x-postLink :post="$post"></x-postLink>
    @endforeach
</x-layout>