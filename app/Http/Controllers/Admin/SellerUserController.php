<?php

namespace App\Http\Controllers\Admin;
 use App\Http\Controllers\Controller;
use App\Models\SellerUser;
use Dotenv\Validator;
use Illuminate\Http\Request;

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
        $sellerUser->delete();
        return redirect()->route('admin.seller-user.index')->with('success', 'Seller User deleted successfully.');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('seller_user.create'), 404);
        $validator = Validator::make($request->all(),[
            
        ])
    }
}
