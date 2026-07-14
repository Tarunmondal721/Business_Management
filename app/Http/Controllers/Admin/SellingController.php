<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellingRequest;
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

        $sellings = Departureproduct::with('seller')
            ->latest()
            ->get();

        return view('admin.sellingproduct.index', compact('sellings'));
    }

    public function show($id)
    {
        abort_unless(auth()->guard('web')->user()->can('selling.view'), 404);

        $selling = Departureproduct::with([
            'seller',
            'arrival',
            'fishes.departureFish',
            'fishes.arrivalFish'
        ])->findOrFail($id);

        return view('admin.sellingproduct.show', compact('selling'));
    }

    public function create()
    {
        abort_unless(auth()->guard('web')->user()->can('selling.create'), 404);
        $selleruser = SellerUser::GetBystatus()->get();
        $fish = Fish::GetBystatus()->get();
        return view('admin.sellingproduct.add_edit', compact('selleruser', 'fish'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $departure = Departureproduct::findOrFail($id);

            ArrivalProduct::where('departure_id', $departure->id)->delete();

            DepartureAndArrivalFish::where('departure_id', $departure->id)->delete();

            $departure->delete();

            DB::commit();

            return response()->json([
                'success' => 1,
                'message' => 'Selling deleted successfully.'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function store(SellingRequest $request)
    {
        abort_unless(auth()->guard('web')->user()->can('selling.create'), 404);
        // dd($request->all());



        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Upload Attachment
        |--------------------------------------------------------------------------
        */



            $attachments = [];

            if ($request->hasFile('attachment')) {

                foreach ($request->file('attachment') as $file) {

                    $fileName = uniqid() . '_' . $file->getClientOriginalExtension();

                    Storage::disk('public')->putFileAs(
                        'bill/attachment',
                        $file,
                        $fileName
                    );

                    $attachments[] =  $fileName;
                }
            }
            $attachment = json_encode($attachments);

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
                'unit'            =>  $request->unit,
                'total_weight'    => $request->total_weight,
                'departure_date'  => $request->departure_date,
                'expected_arrival_date'    => $request->arrival_date,
                'booking_cost_per_bag' => $request->booking_cost_per_bag,
                'total_booking_cost' => $request->total_booking_cost,
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
                'billing_date' => $request->billing_date,

            ]);

            /*
        |--------------------------------------------------------------------------
        | Fish Details
        |--------------------------------------------------------------------------
        */

            foreach ($request->departure_fish_id as $key => $fish) {

                $quantity = $request->departure_quantity[$key] ?? 0;
                $weight   = $request->departure_weight[$key] ?? 0;
                $unit     = $request->departure_unit[$key] ?? '';
                $total_weight = $request->departure_total_weight[$key] ?? 0;
                // $price    = $request->price[$key] ?? 0;

                DepartureAndArrivalFish::create([

                    'departure_id'  => $departure->id,
                    // 'arrival_id'    => $arrival->id,
                    'departure_fish_id'       => $fish,

                    'departure_quantity'      => $quantity,
                    'departure_weight'        => $weight,
                    'departure_unit'          => $unit,
                    'departure_total_weight'  => $total_weight,

                    'departure_total_fish'     => $request->departure_total_fish ?? 0,
                    'departure_total_quantity' => $request->departure_total_quantity ?? 0,
                    'departure_grand_total_weight' => $request->departure_grand_total_weight ?? 0,

                ]);
            }

            if ($request->hasfile('attachment') && count($request->bill_fish_id) > 0) {

                foreach ($request->bill_fish_id as $key => $fish) {

                    $quantity = $request->bill_quantity[$key] ?? 0;
                    $weight   = $request->bill_weight[$key] ?? 0;
                    $unit     = $request->bill_unit[$key] ?? '';
                    $price    = $request->bill_price[$key] ?? 0;
                    $total_weight = $request->bill_total_weight[$key] ?? 0;
                    $total_price = $request->bill_total_price[$key] ?? 0;


                    DepartureAndArrivalFish::create([
                        'departure_id'  => $departure->id,
                        'arrival_id'    => $arrival->id,
                        'arrival_fish_id'       => $fish,
                        'bill_quantity'      => $quantity,
                        'bill_weight'        => $weight,
                        'bill_unit'          => $unit,
                        'bill_price'         => $price,
                        'bill_total_weight'  => $total_weight,
                        'bill_total_price'   => $total_price,

                        'grand_total'         => $request->grand_total ?? 0,
                        'bill_grand_total_weight' => $request->bill_grand_total_weight ?? 0,
                        'bill_total_fish'     => $request->bill_total_fish ?? 0,
                        'bill_total_quantity' => $request->bill_total_quantity ?? 0,

                    ]);
                }
            }


            DB::commit();

            return response()->json([
                'success' => 1,
                'message' => 'Selling Product Added Successfully.',
                'redirect' => route('admin.selling.index'),
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
