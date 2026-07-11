<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fish;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FishController extends Controller
{
    public function index()
    {

        abort_unless(auth()->guard('web')->user()->can('fish.view'), 403);
        $allfish = Fish::all();
        return view('admin.fish.index', compact('allfish'));
    }

    public function create()
    {
        abort_unless(auth()->guard('web')->user()->can('fish.create'), 403);
        return view('admin.fish.add_edit');
    }

    public function edit(String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('fish.edit'), 403);
        $fish = Fish::find($id);
        return view('admin.fish.add_edit', compact('fish'));
    }

    public function destroy(String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('fish.delete'), 403);
        $fish = Fish::find($id);
        if($fish->image && Storage::disk('public')->exists('fish/' . $fish->image)) {
            Storage::disk('public')->delete('fish/' . $fish->image);
        }
        $fish->delete();
        Toastr::success('Fish deleted successfully.');
        return redirect()->route('admin.fish.index');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('fish.create'), 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            DB::beginTransaction();
            $fish = new Fish();
            $fish->name = $request->name;


            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('fish', $image, $imageName);
                $fish->image = $imageName;
            }
            $fish->save();
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Fish added successfully',
                'redirect' => route('admin.fish.index'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fish add error', $e->getMessage());
        }
    }
 public function update(Request $request, String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('fish.edit'), 403);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            DB::beginTransaction();
            $fish = Fish::findorfail($id);
            $fish->name = $request->name;


            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('fish', $image, $imageName);
                $fish->image = $imageName;
            }
            $fish->save();
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Fish updated successfully',
                'redirect' => route('admin.fish.index'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Fish add error', $e->getMessage());
        }
    }

}
