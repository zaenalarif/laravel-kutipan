@extends('layouts.app')

@section('content')
<div class="container">

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>        
                @endforeach
            </ul>    
        </div> 
    @endif

    <form method="POST" action="/quote-comment/{{ $comment->id }}">
        <div class="form-group">
            <label for="subject">Komentar</label>
            <textarea name="subject" class="form-control" id="" cols="30" rows="10" placeholder="koemntar disini">{{ old('subject')? old('subject') : $comment->subject }}</textarea>
        </div>

        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
@endsection
