@extends('layouts.main')

@section('title','ブログ')

@section('content')
<article>
    <x-headline title="ブログ" />
    @include('components.blog.list')
    {{ $blog_list->links('components.pagenation') }}
</article>
@endsection
