<?php

namespace App\Http\Controllers;

use App\Jobs\SendAdminEmail;
use App\Events\ForumCreated;
use Auth;
use App\Models\Tag;
use App\Models\Quote;
use App\Models\User;
use App\Models\QuoteComment;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    
    public function index(Request $request)
    {
        $search_q = urlencode($request->input('search'));
        $tags = Tag::all();
        if(!empty($search_q))
            $quotes = Quote::with('tags')->where('title', 'like', '%'.$search_q.'%')->get();
        else
            $quotes = Quote::with('tags')->get();
        
        return view('quotes.index', compact('quotes', 'tags'));
    }

    public function filter($tag)
    {   
        
        $tags = Tag::all();

        $quotes = Quote::with('tags')->whereHas('tags', function($query) use ($tag){
            $query->where('name', $tag);
        })->get();
        
        return view('quotes.index', compact('quotes', 'tags'));
    }

    public function random()
    {   
        
        $quote = Quote::inRandomOrder()->first();
        
        return view('quotes.single', compact('quote'));
    }

    
    public function create()
    {
        $tags = Tag::all();
        return view('quotes.create', compact('tags'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|min:3',
            'subject'   => 'required|min:10'
        ]);
        $request->tags = array_diff($request->tags, [0]);
        if(empty($request->tags))
            return redirect('/quotes/create')->withInput($request->input())->with('tag_err', 'Tag ngga boleh kosong');    

        $slug = str_slug($request->title, '-');
        
        if (Quote::where('slug', $slug)->first() != null) 
            $slug = $slug . time();

        $quote = Quote::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'subject' => $request->subject,
            'user_id' => Auth::user()->id,
        ]);
        
        
        $quote->tags()->attach($request->tags);
        
        // event(new ForumCreated($quote));
        // ForumCreated::dispatch($quote);
        
        return redirect('/quotes')->with('msg', 'kutipan berhasil ditambahkan');
    }

    
    public function show($slug)
    {
        $quote = Quote::with('comments.user')->where('slug', $slug)->first();
        // uji already exist 
        if ($quote == null){
            abort(404);
        }

        return view('quotes.single', compact('quote'));

    }

    
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        $tags  = Tag::all();
        return view('quotes.edit', compact('quote', 'tags'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'   => 'required|min:3',
            'subject' => 'required|min:10'
        ]);
        $quote = Quote::findOrFail($id);
        
        $request->tags = array_diff($request->tags, [0]);
        if(empty($request->tags))
            return redirect('/quotes/create')->withInput($request->input())->with('tag_err', 'Tag ngga boleh kosong');
        
        if ($quote->isOwner()){
            $quote->update([
                'title'     => $request->title,
                'subject'   => $request->subject
            ]);
            $quote->tags()->sync($request->tags);
        }
        else abort(403);

        return redirect('/quotes')->with('msg', 'Kutipan berhasil di edit');
    }

    
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        
        if($quote->isOwner())
            $quote->delete();
        else abort(403);

        return redirect('/quotes')->with('msg', 'Kutipan berhasil dihapus');
    }
}