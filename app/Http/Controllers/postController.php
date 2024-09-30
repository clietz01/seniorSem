<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;

class postController extends Controller
{
    //

    public function storePost(Request $request){
        $incoming_fields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $newPost = post::create($incoming_fields);

        return redirect('/submit', ['post' => $newPost]);
    }
}
    