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

    <form method="POST" action="/quotes">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" placeholder="tulis judul disini" value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label for="subject">subject</label>
            <textarea name="subject" class="form-control" id="" cols="30" rows="10" placeholder="deskripsi disini">{{ old('subject') }}</textarea>
        </div>

        @if(session('tag_err'))
            <div class="alert alert-danger">Tag ngga boleh kosong</div>
        @endif
        
        <div id="tag_wrapper">
            <label for="">Tag (max 3)</label>
            <div id="add_tag">Add tag</div>
            
            <select name="tags[]" id="tag_select">
                    <option value="0">Tidak Ada</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>    
                @endforeach
            </select>
        </div>

        <script src="{{ asset('js/tag.js') }}"></script>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-default btn-block">Submit</button>
    </form>
</div>
@endsection
