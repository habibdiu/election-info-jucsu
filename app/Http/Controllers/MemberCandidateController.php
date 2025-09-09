<?php

namespace App\Http\Controllers;
use PDOException;
use App\Models\Position;
use App\Models\ElectionArea;
use Illuminate\Http\Request;
use App\Models\MemberCandidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class MemberCandidateController extends Controller
{

    public function member_candidate_add(Request $request)
    {
        $data = [];
        $data['positions'] = Position::all();
        $data['election_areas'] = ElectionArea::all();

        if ($request->isMethod('post')) {
            $photo = $request->file('photo');
            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/member_candidates/' . uniqid() . '.' . $photo_extension;
                $image = Image::make($photo);
                $image->resize(300, 300);
                $image->save($photo_name);
            } else {
                $photo_name = null;
            }

            try {
                MemberCandidate::create([
                    'name' => $request->name,
                    'position_id' => $request->position,
                    'details' => $request->details,
                    'election_area_id' => $request->election_area,
                    'member_no' => $request->member_no,
                    'ballot_no' => $request->ballot_no,
                    'photo' => $photo_name,
                ]);

                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }

        return view('member_candidate_list', compact('data'));
    }



    public function member_candidate_edit(Request $request, $id)
    {
        $data = [];
        $data['member_candidate'] = MemberCandidate::find($id);
        $data['positions'] = Position::all();
        $data['election_areas'] = ElectionArea::all();

        if ($request->isMethod('post')) {
            $old_photo = $data['member_candidate']->photo;
            $photo = $request->file('photo');

            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/member_candidates/' . uniqid() . '.' . $photo_extension;
                $image = Image::make($photo);
                $image->resize(300, 300);
                $image->save($photo_name);

                if (File::exists($old_photo)) {
                    File::delete($old_photo);
                }
            } else {
                $photo_name = $old_photo;
            }

            try {
                $data['member_candidate']->update([
                    'name' => $request->name,
                    'position_id' => $request->position,
                    'details' => $request->details,
                    'election_area_id' => $request->election_area,
                    'member_no' => $request->member_no,
                    'ballot_no' => $request->ballot_no,
                    'photo' => $photo_name,
                ]);

                return back()->with('success', 'Updated Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }

        return view('member_candidate_list', compact('data'));
    }

    public function member_candidate_list()
    {
        $data = [];
        $data['member_candidate_list'] = MemberCandidate::with(['position', 'election_area'])->paginate(10);
        $data['positions'] = Position::all();
        $data['election_areas'] = ElectionArea::all();

        return view('member_candidate_list', ['data' => $data]);
    }



    public function member_candidate_delete($id)
    {
        $member_candidate = MemberCandidate::find($id);

        if ($member_candidate) {
            $photo_path = public_path($member_candidate->photo);
            if (File::exists($photo_path)) {
                File::delete($photo_path);
            }
            $member_candidate->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Deleted Successfully']);
        }

        return response()->json(['status' => 'FAILED', 'message' => 'Not Found']);
    }

}
