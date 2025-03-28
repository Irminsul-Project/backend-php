<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function CreateForum(Request $Request) {
        $post = new Forum();
        $post->title = $Request->title;
        $post->content = $Request->content;
        $post->save();


        return [
            "Data" => [
                "Id" => $post->_id
            ],
            "Message" => "Insert Success"
        ];
    }
}
