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

    <form method="POST" action="/quotes/{{ $quote->id }}">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" placeholder="tulis judul disini" value="{{ old('title') ? old('title') : $quote->title}}">
        </div>
        <div class="form-group">
            <label for="subject">subject</label>
            <textarea name="subject" class="form-control" id="" cols="30" rows="10" placeholder="deskripsi disini">{{ old('subject') ? old('subject') : $quote->subject }}</textarea>
        </div>

        <div id="tag_wrapper">
            <label for="">Tag (max 3)</label>
            <div id="add_tag">Add tag</div>

        @foreach ($quote->tags as $oldtags)                
            <select name="tags[]" id="tag_select">
                    <option value="0">Tidak Ada</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        @if ($oldtags->id == $tag->id)
                            selected="selected"    
                        @endif
                        >{{ $tag->name }}</option>    
                @endforeach
            </select>
        @endforeach
        </div>

        <script src="{{ asset('js/tag.js') }}"></script>
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-default">Edit Kutipan</button>
    </form>
</div>
@endsection
