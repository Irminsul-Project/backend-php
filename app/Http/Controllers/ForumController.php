<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Forum;
use App\Models\Tag;
use App\Models\ForumTag;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ForumController extends Controller
{
    public function Search(Request $Request) {
        $Forums = Forum::get();
        $TagsId = collect([]);

        foreach ($Forums as $Forum) {
            $CreateUserId = $Forum->create_user ?? null;
            if ($CreateUserId !== null) {
                $User = User::find($CreateUserId);
    
                $Forum->create_user = $User->name;
                $ForumTags = $Forum->Tags()->select("tag")->get()->pluck("tag");
                $Forum->tags = $ForumTags;

                $TagsId = $TagsId->union($ForumTags);
            }
        }

        $Tags = Tag::whereIn("id", $TagsId)
            ->select("id as Id", "code as Code", "description as Description")
            ->get();

        return [
            "Data" => [
                "Forums" => $Forums,
                "Tags" => $Tags
            ],
            "message" => []
        ];
    }

    public function Create(Request $Request) {
        $User = Auth::user();

        $Forum = new Forum();
        $Forum->title = $Request->title;
        $Forum->content = $Request->content;
        $Forum->create_user = $User->id;
        $Forum->save();

        $Tags = $Request->tags ?? [];
        foreach ($Tags as $Tag) {
            $TagModel = Tag::find($Tag);
            if ($TagModel !== null) {
                $ForumTag = new ForumTag([
                    "tag" => $Tag
                ]);

                $Forum->Tags()->save($ForumTag);
            }
        }

        return [
            "Data" => [
                "Id" => $Forum->_id
            ],
            "message" => ["Create Success"]
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
                "Id" => $Comment->_id,
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
            "message" => []
        ];
    }

    public function CommendAdd(Request $Request, String $Id) {
        $User = Auth::user();

        $Forum = Forum::find($Id);

        $Comment = new Comment([
            "content" => $Request->content,
            "create_user" => $User->id
        ]);

        $Forum->Comments()->save($Comment);

        return [
            "Data" => [
                "Id" => $Comment->_id
            ],
            "message" => ["Add Success"]
        ];
    }
}
