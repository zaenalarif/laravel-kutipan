<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Quote;
use App\Models\QuoteComment;

use Illuminate\Http\Request;

class QuoteCommentController extends Controller
{
    public function store(Request $request, $id)
    {   
        // masih diabaikan ngebug
        $this->validate($request, [
            'subject'   => 'max:4',
        ]);
        
        $quote = Quote::findOrfail($id);
     
        $comment = QuoteComment::create([
            'subject'   =>  $request->comment,
            'quote_id'  =>  $id,
            'user_id'   =>  Auth::user()->id
        ]);
        // dd($comment);
        return redirect('/quotes/'.$quote->slug)->with('msg', 'Komentar berhasil di tambahkan');
    }

    public function edit($id)
    {
        $comment =QuoteComment::findOrFail($id);

        return view('quote-comment.edit', compact('comment'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required'
        ]);
        
        // dd($id);
        $comment = QuoteComment::findOrFail($id);
        

        if($comment->isOwner()){
            $comment->update([
                'subject' => $request->subject,
            ]);
        }

        return redirect('/quotes/'.$comment->quote->slug)->with('msg', 'komentar berhasil di edit');
    }

    public function destroy($id)
    {
        $comment = QuoteComment::findOrFail($id);
        if ($comment->isOwner())
            $comment->delete();
        else abort(403);

        return redirect('/quotes/'.$comment->quote->slug)->with('msg',' kutipan berhasil dihapus');
    }
}
