<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Forum;
use App\Models\ForumCommnet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ForumController extends Controller
{
    public function Search(Request $Request) {
        $Forums = Forum::get();

        foreach ($Forums as $Forum) {
            $CreateUserId = $Forum->create_user ?? null;
            if ($CreateUserId !== null) {
                $User = User::find($CreateUserId);
    
                $Forum->create_user = $User->name;
            }
        }

        return [
            "Data" => [
                "Forums" => $Forums
            ],
            "Message" => ""
        ];
    }

    public function Create(Request $Request) {
        $User = Auth::user();

        $Forum = new Forum();
        $Forum->title = $Request->title;
        $Forum->content = $Request->content;
        $Forum->create_user = $User->id;
        $Forum->save();

        return [
            "Data" => [
                "Id" => $Forum->_id
            ],
            "Message" => "Create Success"
        ];
    }

    public function Detail(Request $Request, String $Id) {
        $Comments = [];
        $UserCreates = [];
        $UserCreatesId = [];

        $Forum = Forum::find($Id);

        $CreateUserId = $Forum->create_user ?? null;
        if($CreateUserId != null) {
            $UserCreatesId[] = $CreateUserId;
        }

        foreach ($Forum->Comments as $Comment) {
            $Comments[] = [
                "Content" => $Comment->content,
                "UserCreateId" => $Comment->create_user
            ];

            $CreateUserId = $Comment->create_user ?? null;
            if($CreateUserId != null) {
                $UserCreatesId[] = $CreateUserId;
            }
        }

        $UserCreates = User::whereIn("id", $UserCreatesId)
            ->select("id as Id", "name as Name")
            ->get();
        
        return [
            "Data" => [
                "Forum" => [
                    "Title" => $Forum->title,
                    "Content" => $Forum->content,
                    "UserCreateId" => $Forum->create_user,
                    "Comments" => $Comments,
                ],
                "UserCreates" => $UserCreates
            ],
            "Message" => ""
        ];
    }

    public function CommendAdd(Request $Request, String $Id) {
        $User = Auth::user();

        $Forum = Forum::find($Id);

        $ForumCommnet = new ForumCommnet([
            "content" => $Request->content,
            "create_user" => $User->id
        ]);

        $Forum->Comments()->save($ForumCommnet);

        return [
            "Data" => [
                "Id" => $ForumCommnet->_id
            ],
            "Message" => "Add Success"
        ];
    }
}
