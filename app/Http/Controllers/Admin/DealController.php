<?php


namespace App\Http\Controllers\Admin;
use App\Models\Deal;
use App\Models\DealProduct;
use Illuminate\Http\Request;

class DealController extends HelperAdminController
{
    /**
     * Hiển thị danh sách deal
    */
    public function indexDeal()
    {
        $listData = Deal::orderBy('created_at', 'desc')->paginate(20);
        return view('deals.index', compact('listData'));
    }

    /**
     * Thêm deal mới
    */
    public function storeDeal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'fixed_price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        Deal::create($request->all());

        return redirect()->route('deal.index-deal')->with('success', 'Deal created successfully');
    }

    /**
     * Cập nhật deal
    */
    public function updateDeal(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'fixed_price' => 'nullable|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        $deal = Deal::find($id);
        if ($deal){
            $deal->update($request->all());
        }

        return redirect()->route('deal.index-deal')->with('success', 'Deal updated successfully');
    }

    /**
     * Xóa deal
    */
    public function destroyDeal($id)
    {
        $deal = Deal::find($id);
        if ($deal){
            $deal->delete();
        }
        return redirect()->route('deal.index-deal')->with('success', 'Deal deleted successfully');
    }

    /**
     * Danh sách sản phẩm trong deal
    */
    public function indexDealProduct($deal_id){
        $listData = DealProduct::where('deal_id', $deal_id)->orderBy('display_order', 'asc')->paginate(20);
        $deal = Deal::find($deal_id);
        if (empty($deal)){
            return back()->with(['error' => 'Không tìm thấy deal!']);
        }
        return view('deals.index-deal-product', compact('listData', 'deal'));
    }

    /**
     * Thêm Deal Product
    */
    public function addDealProduct(Request $request)
    {
        $request->validate([
            'deal_id' => 'required|integer',
            'sku' => 'required|string|unique:deal_products',
            'name' => 'required|string',
            'original_price' => 'required|numeric',
            'deal_price' => 'required|numeric',
        ]);

        $product = DealProduct::create($request->all());
        return response()->json($product, 201);
    }

    // Sửa Deal Product
    public function updateDealProduct(Request $request, $id)
    {
        $product = DealProduct::findOrFail($id);

        $request->validate([
            'sku' => 'string|unique:deal_products,sku,'.$id,
            'name' => 'string',
            'original_price' => 'numeric',
            'deal_price' => 'numeric',
            'quantity' => 'integer',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    // Xóa Deal Product
    public function deleteDealProduct($id)
    {
        DealProduct::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // Danh sách Deal Purchases
    public function listDealPurchases()
    {
        $purchases = DealPurchase::all();
        return response()->json($purchases);
    }

    // Thêm Deal Purchase
    public function addDealPurchase(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'deal_product_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'contact_number' => 'required|string',
            'store_id' => 'required|integer',
            'status' => 'in:pending,redeemed,canceled',
        ]);

        $purchase = DealPurchase::create($request->all());
        return response()->json($purchase, 201);
    }

    // Sửa Deal Purchase
    public function updateDealPurchase(Request $request, $id)
    {
        $purchase = DealPurchase::findOrFail($id);

        $request->validate([
            'status' => 'in:pending,redeemed,canceled',
        ]);

        $purchase->update($request->all());
        return response()->json($purchase);
    }

    // Xóa Deal Purchase
    public function deleteDealPurchase($id)
    {
        DealPurchase::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
