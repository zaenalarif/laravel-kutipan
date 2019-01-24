@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>{{ $quote->title }}</h1>
        <p>{{ $quote->subject }}</p>
        <p>Di tulis oleh <a href="/profile/{{ $quote->user->id }}">{{ $quote->user->name }}</a></p>

        <p><a class="btn btn-primary btn-lg" href="/quotes">Kembali ke home</a></p>

        
        @if ( $quote->isOwner())
        <p><a class="btn btn-primary btn-lg" href="/quotes/{{ $quote->id }}/edit">Edit</a></p>
        
        <form method="POST" action="/quotes/{{ $quote->id }}">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endif        
        
    </div>
    @if(session('msg'))
        <div class="alert alert-success">
            <p>{{ session('msg') }}</p>    
        </div> 
    @endif
    <br>
        @foreach ($quote->comments as $comment)
        <div class="list-group-item-info ">
            <p>{{ $comment->subject }}</p>
            <p>Di tulis oleh <a href="/profile/{{ $comment->user->id }}">{{ $comment->user->name }}</a></p>    

            
            @if ($comment->isOwner())
                <a class="btn btn-primary" href="/quote-comment/{{ $comment->id }}/edit">Edit</a>    
                <form method="POST" action="/quote-comment/{{ $comment->id }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>    
            @endif
        </div>
            <hr>
        @endforeach

    
    
    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>        
            @endforeach
        </ul>    
    </div> 
    @endif

    <form method="POST" action="/quote-comment/{{ $quote->id }}">
        <div class="form-group">
            <label for="komentar">Isi Komentar</label>
            <textarea class="form-control" name="comment" cols="30" rows="10"></textarea>
            {{ csrf_field() }}
        </div>
        
        <button type="submit" class="btn btn-success btn-block">Komen</button>
    </form>
</div>
<br>
@endsection
