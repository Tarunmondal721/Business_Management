<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArrivalProduct;
use App\Models\DepartureAndArrivalFish;
use App\Models\Departureproduct;
use App\Models\Fish;
use App\Models\SellerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellingController extends Controller
{
    public function index()
    {
        abort_unless(auth()->guard('web')->user()->can('selling.view'), 404);
        return view('admin.sellingproduct.index');
    }

    public function create()
    {
        abort_unless(auth()->guard('web')->user()->can('selling.create'), 404);
        $selleruser = SellerUser::GetBystatus()->get();
        $fish = Fish::GetBystatus()->get();
        return view('admin.sellingproduct.add_edit', compact('selleruser', 'fish'));
    }


    public function store(Request $request)
    {
        abort_unless(auth()->guard('web')->user()->can('selling.create'), 404);

        $validator = Validator::make($request->all(), [
            'seller_id'      => 'required|exists:seller_users,id',
            'departure_date' => 'required',
            'arrival_date'   => 'nullable',
            'bag_name'       => 'required',
            'fish_id'        => 'required|array',
            'fish_id.*'      => 'required',
            'quantity'       => 'required|array',
            'weight'         => 'required|array',
            'unit'           => 'required|array',
            'price'          => 'required|array',
            'attachment'     => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Upload Attachment
        |--------------------------------------------------------------------------
        */

            $attachment = null;

            if ($request->hasFile('attachment')) {

                $file = $request->file('attachment');
                $attachment = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('bill/attachment', $file, $attachment);
            }

            /*
        |--------------------------------------------------------------------------
        | Departure Product
        |--------------------------------------------------------------------------
        */

            $departure = Departureproduct::create([

                'seller_id'       => $request->seller_id,
                'bag_name'        => $request->bag_name,
                'total_quantity'  => $request->total_quantity,
                'weight_per_bag'  => $request->weight_per_bag,
                'unit'            => $request->unit[0] ?? $request->unit,
                'total_weight'    => $request->total_weight,
                'departure_date'  => $request->departure_date,
                'arrival_date'    => $request->arrival_date,

            ]);

            /*
        |--------------------------------------------------------------------------
        | Arrival Product
        |--------------------------------------------------------------------------
        */

            $arrival = ArrivalProduct::create([

                'departure_id' => $departure->id,
                'arrival_date' => $request->arrival_date,
                'attachment'   => $attachment,

            ]);

            /*
        |--------------------------------------------------------------------------
        | Fish Details
        |--------------------------------------------------------------------------
        */

            foreach ($request->fish_id as $key => $fish) {

                $quantity = $request->quantity[$key] ?? 0;
                $weight   = $request->weight[$key] ?? 0;
                $unit     = $request->unit[$key] ?? '';
                $price    = $request->price[$key] ?? 0;

                DepartureAndArrivalFish::create([

                    'departure_id'  => $departure->id,
                    'arrival_id'    => $arrival->id,
                    'fish_id'       => $fish,

                    'quantity'      => $quantity,
                    'weight'        => $weight,
                    'unit'          => $unit,

                    'total_weight'  => $weight,

                    'total_quantity' => $quantity,

                    'price'         => $price,

                    'total_price'   => $quantity * $price,

                ]);
            }

            DB::commit();

            return response()->json([
                'success' => 1,
                'message' => 'Selling Product Added Successfully.'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Selling Product Store Error', [

                'message' => $e->getMessage(),

                'line' => $e->getLine(),

                'file' => $e->getFile(),

            ]);

            return response()->json([

                'success' => 0,

                'message' => 'Something went wrong.',

            ], 500);
        }
    }
}
