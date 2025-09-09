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
        $data['election_areas'] = ElectionArea::all();

        if ($request->isMethod('post')) {
            try {
                Position::create([
                    'name'             => $request->name,
                    'total_candidate'  => $request->total_candidate,
                    'max_valid_vote'   => $request->max_valid_vote,
                    'min_valid_vote'   => $request->min_valid_vote,
                    'priority'         => $request->priority,
                ]);

                return back()->with('success', 'Added Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }

        return view('position_list', compact('election_areas'));
    }


    public function position_edit(Request $request, $id)
    {
        $position = Position::findOrFail($id);
        $election_areas = ElectionArea::all();

        if ($request->isMethod('post')) {

            try {
                $position->update([
                    'name'             => $request->name,
                    'total_candidate'  => $request->total_candidate,
                    'max_valid_vote'   => $request->max_valid_vote,
                    'min_valid_vote'   => $request->min_valid_vote,
                    'priority'         => $request->priority,
                ]);
                return back()->with('success', 'Updated Successfully');
            } catch (PDOException $e) {
                return back()->with('error', 'Failed Please Try Again');
            }
        }
        return view('position_list', compact('position', 'election_areas'));
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
