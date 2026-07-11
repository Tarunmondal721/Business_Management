<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class SellerUserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.view'), 404);
        $sellerUsers = SellerUser::all();
        return view('admin.seller_user.index', compact('sellerUsers'));
    }

    public function create(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.create'), 404);
        return view('admin.seller_user.add_edit');
    }

    public function edit(Request $request, $id)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.edit'), 404);
        $sellerUser = SellerUser::findOrFail($id);

        return view('admin.seller_user.add_edit', compact('sellerUser'));
    }

    public function destroy(Request $request, $id)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.delete'), 404);
        $sellerUser = SellerUser::findOrFail($id);
        if($sellerUser->image && Storage::disk('public')->exists('seller_users/' . $sellerUser->image)) {
            Storage::disk('public')->delete('seller_users/' . $sellerUser->image);
        }
        $sellerUser->delete();
        return redirect()->route('admin.user.index')->with('success', 'Seller User deleted successfully.');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.create'), 404);

        $validator = FacadesValidator::make($request->all(), [
            'name'            => 'required|max:255',
            'phone'           => 'required|digits_between:10,15',
            'email'           => 'nullable|email|unique:seller_users,email',
            'address'         => 'nullable|max:500',
            'company_name'     => 'nullable|max:255',
            'country'         => 'nullable|max:255',
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
            $sellerUser = new SellerUser();
            $sellerUser->name = $request->name;
            $sellerUser->email = $request->email;
            $sellerUser->phone = $request->phone;
            $sellerUser->address = $request->address;
            $sellerUser->company_name = $request->company_name;
            $sellerUser->country = $request->country;
            $sellerUser->status = $request->status;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Storage::disk('public')->makeDirectory('buyer_users');
                Storage::disk('public')->putFileAs('seller_users', $image, $imageName);
                $sellerUser->image = $imageName;
            }
            $sellerUser->save();
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Seller User created successfully.',
                 'redirect' => route('admin.seller-user.index'
                 )], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, String $id)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.edit'), 404);
        $validator = FacadesValidator::make($request->all(), [
            'name'            => 'required|max:255',
            'phone'           => 'required|digits_between:10,15',
            'email'           => 'nullable|email|unique:seller_users,email,'.$id,
            'address'         => 'nullable|max:500',
            'company_name'     => 'nullable|max:255',
            'country'         => 'nullable|max:255',
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
            $selleruser = SellerUser::findOrFail($id);
            $selleruser->name = $request->name;
            $selleruser->email = $request->email;
            $selleruser->phone = $request->phone;
            $selleruser->address = $request->address;
            $selleruser->company_name = $request->company_name;
            $selleruser->status = $request->status;
            $selleruser->country = $request->country;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Storage::disk('public')->makeDirectory('buyer_users');
                Storage::disk('public')->putFileAs('seller_users', $image, $imageName);
                $selleruser->image = $imageName;
            }
            $selleruser->save();
            DB::commit();
            return response()->json(['success' => 1, 'message' => 'Seller User updated successfully.', 'redirect' => route('admin.seller-user.index')], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }
}
