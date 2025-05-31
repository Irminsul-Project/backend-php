<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class TagController extends Controller
{
    public function Search() {
        $Tags = Tag::where([
            "status" => "accept"
        ])
            ->select("id as Id", "code as Code", "description as Description")
            ->get();

        return [
            "Data" => [
                "Tags" => $Tags
            ],
            "message" => []
        ];
    }

    public function RequestAdd(Request $Request) {
        $User = Auth::user();

        $Tag = new Tag();
        $Tag->code = $Request->code;
        $Tag->description = $Request->description;
        $Tag->reason = $Request->reason;
        $Tag->action_user = $User->id;
        $Tag->status = "accept";
        $Tag->save();

        return [
            "Data" => [
                "Id" => $Tag->id
            ],
            "message" => ["Create Success"]
        ];
    }
}
