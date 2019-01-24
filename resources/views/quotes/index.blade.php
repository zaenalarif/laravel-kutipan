@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('msg'))
        <div class="alert alert-success">
            <p>{{ session('msg') }}</p>    
        </div> 
    @endif
    
    <div class="row">
        <div>Tag:
        
            @foreach ($tags as $tag)
                <a href="/quotes/filter/{{ $tag->name }}">{{ $tag->name }}</a>
            @endforeach
        
        </div>    
        <div class="col-md-5 col-md-offset-4">
            <form class="navbar-form navbar-left" action="/quotes" method="GET">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="search" name="search">
                </div>
            </form>
        </div>
        <a class="btn btn-primary" href="/quotes/create">Create</a>
        
    </div>
    <div class="row">
        @foreach ($quotes as $quote)
            <div class="col-md-4">
                <div class="thumbnail">
                    <h1>{{ $quote->title }}</h1>
                    @if (count($quote->tags) > 0)
                    <div>Tag:
                        @foreach ($quote->tags as $tag)
                            <a href="">{{ $tag->name }}</a>
                        @endforeach
                    </div>    
                    @endif
                    
                    <p class="btn alert-warning"><a href="/quotes/{{ $quote->slug }}">Lihat Kutipan</a></p>  
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
