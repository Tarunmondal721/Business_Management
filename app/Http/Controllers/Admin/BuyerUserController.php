<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerUser;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BuyerUserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('buyer_user.view'), 404);
        $buyerUsers = BuyerUser::all();
        return view('admin.buyer_user.index', compact('buyerUsers'));
    }

    public function create(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('buyer_user.create'), 404);
        return view('admin.buyer_user.add-edit');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->expectsJson(), $request->ajax());
        abort_unless(auth()->guard('web')->user()->can('buyer_user.create'), 404);
        $validator = Validator::make($request->all(), [
            'buyer_code'      => 'required|unique:buyer_users,buyer_code',
            'name'            => 'required|max:255',
            'phone'           => 'required|digits_between:10,15',
            'email'           => 'nullable|email|unique:buyer_users,email',
            'address'         => 'nullable|max:500',
            'type'            => 'required|in:agent,wholeseller',
            'market_name'     => 'nullable|max:255',
            'market_address'  => 'nullable|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'          => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $buyerUser = new BuyerUser();
            $buyerUser->name = $request->name;
            $buyerUser->email = $request->email;
            $buyerUser->phone = $request->phone;
            $buyerUser->address = $request->address;
            $buyerUser->type = $request->type;
            $buyerUser->buyer_code = $request->buyer_code;
            $buyerUser->market_name = $request->market_name;
            $buyerUser->market_address = $request->market_address;
            $buyerUser->status = $request->status;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Storage::disk('public')->makeDirectory('buyer_users');
                Storage::disk('public')->putFileAs('buyer_users', $image, $imageName);
                $buyerUser->image = $imageName;
            }
            $buyerUser->save();

            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Buyer User created successfully',
                'redirect' => route('admin.buyer-user.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating buyer user: ' . $e->getMessage());
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit(String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('buyer_user.edit'), 404);
        $buyerUser = BuyerUser::findOrFail($id);
        return view('admin.buyer_user.add-edit', compact('buyerUser'));
    }

    public function update(Request $request, String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('buyer_user.edit'), 404);
        $validator = Validator::make($request->all(), [
            'buyer_code'      => 'required|unique:buyer_users,buyer_code,' . $id,
            'name'            => 'required|max:255',
            'phone'           => 'required|digits_between:10,15',
            'email'           => 'nullable|email|unique:buyer_users,email,' . $id,
            'address'         => 'nullable|max:500',
            'type'            => 'required|in:agent,wholeseller',
            'market_name'     => 'nullable|max:255',
            'market_address'  => 'nullable|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'          => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $buyerUser = BuyerUser::findOrFail($id);
            $buyerUser->name = $request->name;
            $buyerUser->email = $request->email;
            $buyerUser->phone = $request->phone;
            $buyerUser->address = $request->address;
            $buyerUser->type = $request->type;
            $buyerUser->buyer_code = $request->buyer_code;
            $buyerUser->market_name = $request->market_name;
            $buyerUser->market_address = $request->market_address;
            $buyerUser->status = $request->status;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($buyerUser->image && Storage::disk('public')->exists('buyer_users/' . $buyerUser->image)) {
                    Storage::disk('public')->delete('buyer_users/' . $buyerUser->image);
                }
                // Store new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('buyer_users', $image, $imageName);
                $buyerUser->image = $imageName;
            }

            $buyerUser->save();

            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Buyer User updated successfully',
                'redirect' => route('admin.buyer-user.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating buyer user: ' . $e->getMessage());
            return response()->json([
                'success' => 0,
                'message' => 'An error occurred while updating the buyer user.',
            ]);
        }
    }

    public function destroy(String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('buyer_user.delete'), 404);
        $buyerUser = BuyerUser::findOrFail($id); 

        if($buyerUser->image && Storage::disk('public')->exists('buyer_users/' . $buyerUser->image)) {
            Storage::disk('public')->delete('buyer_users/' . $buyerUser->image);
        }
        $buyerUser->delete();
        Toastr::success('Role and its assigned permissions deleted successfully!');
    }
}
