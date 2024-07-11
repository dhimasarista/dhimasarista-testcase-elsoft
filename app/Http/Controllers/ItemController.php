<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Currency;
use App\Models\Item;
use App\Models\ItemGroup;
use App\Models\ItemType;
use App\Models\ItemUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $username = session('username');

        $itemGroups = ItemGroup::all();
        $itemUnits = ItemUnit::all();
        $currencies = Currency::all();

        // Cari company berdasarkan company_id user
        $user = User::where("username", $username)->first();
        $companyName = $user && $user->company ? $user->company->name : null ;
        return view("item", [
            "itemGroups" => $itemGroups,
            "itemUnits" => $itemUnits,
            "currencies" => $currencies,
            "companyName" => $companyName
        ]);
    }

    public function findAll()
    {
        $items = Item::with([
            'company',
            'itemType',
            'itemGroup',
            'itemAccountGroup',
            'itemUnit',
        ])->whereNull('deleted_at')->get();

        return response()->json([
            "items" => $items,
            "status" => 200
        ]);
    }
    public function findById($id){
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
                'status' => 404
            ], 404);
        }
        return response()->json([
            "item" => $item,
            "status" => 200
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'label' => 'required|string',
            'item_group_id' => 'nullable|exists:item_groups,id',
            'item_account_group_id' => 'nullable|exists:item_account_groups,id',
            'item_unit_id' => 'nullable|exists:item_units,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        $username = session('username');
        // Cari company berdasarkan company_id user
        $user = User::where("username", $username)->first();

        // Cari jenis item (item_type) berdasarkan nama 'Product'
        $itemType = ItemType::where("name", "Product")->first();
        if (!$itemType) {
            return response()->json([
                'error' => 'Item type not found',
                'status' => 404
            ], 404);
        }

        // Buat array data untuk item baru
        $data = $request->all();
        $data['company_id'] = $user->company_id;
        $data['item_type_id'] = $itemType->id;

        // Generate random code if <<Auto>> is selected
        if ($data['code'] === '<<Auto>>') {
            $data['code'] = mt_rand(100000, 999999); // Generate random 6-digit number
        }

        // Simpan item baru
        Item::create($data);

        return response()->json([
            'message' => "Success create item",
            'status' => 200
        ], 201);
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string',
            'item_group_id' => 'nullable|exists:item_groups,id',
            'item_account_group_id' => 'nullable|exists:item_account_groups,id',
            'item_unit_id' => 'nullable|exists:item_units,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
                'status' => 404
            ], 404);
        }

        $item->update($request->all());

        return response()->json([
            'item' => $item,
            'status' => 200
        ], 200);
    }
    public function softDelete(string $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
                'status' => 404
            ], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'Item soft deleted successfully',
            'status' => 200
        ], 200);
    }
}
