<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\Position;
use App\Models\ElectionArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class PositionController extends Controller
{

    public function position_add(Request $request)
    {
        $data = [];
        $data['positions'] = Position::all();
        $data['election_areas'] = ElectionArea::all();

        if ($request->isMethod('post')) {            

            try {
                Position::create([
                    'name' => $request->name,
                    'total_candidate' => $request->total_candidate,
                    'max_valid_vote' => $request->max_valid_vote,
                    'min_valid_vote' => $request->min_valid_vote,
                    'member_no' => $request->member_no,
                    'ballot_no' => $request->ballot_no,
                ]);

                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }

        return view('position_add', compact('data'));
    }

    public function position_edit(Request $request, $id)
    {
        $data = [];
        $data['position'] = Position::find($id);
        $data['positions'] = Position::all();
        $data['election_areas'] = ElectionArea::all();

        if ($request->isMethod('post')) {
            $old_photo = $data['position']->photo;
            $photo = $request->file('photo');

            if ($photo) {
                $photo_extension = $photo->getClientOriginalExtension();
                $photo_name = 'backend_assets/images/positions/' . uniqid() . '.' . $photo_extension;
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
                $data['position']->update([
                    'name' => $request->name,
                    'position_id' => $request->position,
                    'details' => $request->details,
                    'max_valid_vote' => $request->election_area,
                    'member_no' => $request->member_no,
                    'ballot_no' => $request->ballot_no,
                    'photo' => $photo_name,
                ]);

                return back()->with('success', 'Updated Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }

        return view('position_edit', compact('data'));
    }

    public function position_list()
    {
        $data = [];
        $data['position_list'] = Position::with(['election_area'])->paginate(10);
        return view('position_list', compact('data'));
    }

    public function position_delete($id)
    {
        $position = Position::find($id);

        if ($position) {
            $photo_path = public_path($position->photo);
            if (File::exists($photo_path)) {
                File::delete($photo_path);
            }
            $position->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Deleted Successfully']);
        }

        return response()->json(['status' => 'FAILED', 'message' => 'Not Found']);
    }

}
