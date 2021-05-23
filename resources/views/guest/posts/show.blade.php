@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{$post['title']}}</h1>
                <h3>Scritto da <strong>{{$post->user->name}}</strong></h3>
                <h6>Categoria: {{$post->category->name}}</h6>
                <p>{{$post['content']}}</p>
            </div>
        </div>
    </div>
@endsection
