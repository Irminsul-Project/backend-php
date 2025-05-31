<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Research;
use App\Models\ResearchContributor;
use App\Models\ResearchTarget;
use App\Models\ResearchTargetHistory;
use App\Models\Tag;
use App\Models\ResearchTimeLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ReasearchController extends Controller
{
    public function Search(Request $Request) {
        $Researchs = Research::with("Contributor")->get();

        foreach ($Researchs as $Research) {
            $Research->id = $Research->_id;
            unset($Research->_id);
            unset($Research->created_at);
            
            $Research->origin = $Research->Contributor()
                ->where("contributor_rule", "Origin")
                ->first();

            if ($Research->origin !== null) {
                $UserId = $Research->origin->user_id;

                $Research->origin = User::where("id", $UserId)
                    ->select("id", "name")
                    ->first();
            }
        }

        return [
            "data" => [
                "researchs" => $Researchs
            ],
            "message" => []
        ];
    }

    public function Create(Request $Request) {
        $User = Auth::user();

        $Research = new Research();
        $Research->title = $Request->title;
        $Research->content = $Request->content;
        $Research->status = "OnProcess";
        $Research->save();

        $ResearchContributor = new ResearchContributor([
            "user_id" => $User->id,
            "contributor_rule" => "Origin",
            "contributor_status" => "Active"
        ]);

        $Research->Contributor()->save($ResearchContributor);

        foreach ($Request->target as $Target) {
            $ResearchTarget = new ResearchTarget([
                "content" => $Target,
                "status" => "Create",
                "user_id" => $User->id
            ]);

            $ResearchTarget->TargetHistory()->save(new ResearchTargetHistory([
                "content" => $Target,
                "status_change" => "Create",
                "user_id" => $User->id,
            ]));

            $Research->Target()->save($ResearchTarget);
        }

        return [
            "data" => [
                "id" => $Research->_id
            ],
            "message" => ["Create Success"]
        ];
    }

    public function TimeLineCreate(String $Id, Request $Request) {
        $User = Auth::user();

        $Research = Research::find($Id);

        $ResearchTimeLine = new ResearchTimeLine([
            "user_id" => $User->id,
            "title" => $Request->title,
            "content" => $Request->content,
            "status" => "Draft"
        ]);

        $Research->TimeLine()->save($ResearchTimeLine);

        return [
            "data" => [
            ],
            "message" => ["Create Success"]
        ];
    }

    public function Detail(String $Id) {
        $UserCreates = [];

        $Research = Research::find($Id);

        $Contributors = [];
        $TimeLines = [];
        $Targets = [];

        foreach ($Research->Contributor as $Contributor) {
            $UserCreates[] = $Contributor->user_id;

            $Contributors[] = [
                "id" => $Contributor->_id,
                "user_id" => $Contributor->user_id,
                "status" => $Contributor->status,
                "contributor_rule" => $Contributor->contributor_rule,
                "contributor_status" => $Contributor->contributor_status
            ];
        }

        foreach ($Research->TimeLine as $TimeLine) {
            $TimeLines[] = [
                "id" => $TimeLine->_id,
                "user_id" => $TimeLine->user_id,
                "title" => $TimeLine->title,
                "content" => $TimeLine->content,
                "status" => $TimeLine->status,
                "created_at" => $TimeLine->created_at
            ];
        }

        foreach ($Research->Target as $Target) {
            $Targets[] = [
                "id" => $Target->_id,
                "user_id" => $Target->user_id,
                "content" => $Target->content,
                "status" => $Target->status
            ];
        }

        $users = User::whereIn("id", $UserCreates)
            ->select("id", "name")->get();

        return [
            "data" => [
                "research" => [
                    "title" => $Research->title,
                    "content" => $Research->content,
                ],
                "contributors" => $Contributors,
                "targets" => $Targets,
                "timelines" => $TimeLines,
                "users" => $users
            ],
            "message" => []
        ];
    }
}
