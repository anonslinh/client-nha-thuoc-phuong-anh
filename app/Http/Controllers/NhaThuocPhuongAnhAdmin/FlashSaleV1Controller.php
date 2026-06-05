<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\FlashSaleItemV1;
use App\Models\FlashSaleV1;
use App\Models\ProductV1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FlashSaleV1Controller extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month');
        $monthCarbon = $month
            ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
            : Carbon::now()->startOfMonth();

        $start = $monthCarbon->copy()->startOfMonth();
        $end = $monthCarbon->copy()->endOfMonth();

        $sessions = FlashSaleV1::query()
            ->whereBetween('sale_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('sale_date')
            ->orderBy('start_time')
            ->get();

        $sessionIds = $sessions->pluck('id')->all();

        $countMap = [];
        if (!empty($sessionIds)) {
            $countMap = FlashSaleItemV1::query()
                ->select('flash_sale_id', DB::raw('COUNT(*) as c'))
                ->whereIn('flash_sale_id', $sessionIds)
                ->groupBy('flash_sale_id')
                ->pluck('c', 'flash_sale_id')
                ->toArray();
        }

        $byDate = $sessions->groupBy('sale_date');

        $firstDayOfCalendar = $start->copy()->startOfWeek(Carbon::MONDAY);
        $lastDayOfCalendar = $end->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        $cursor = $firstDayOfCalendar->copy();

        while ($cursor <= $lastDayOfCalendar) {
            $days[] = $cursor->copy();
            $cursor->addDay();
        }

        $weeks = array_chunk($days, 7);

        $prevMonth = $monthCarbon->copy()->subMonth()->format('Y-m');
        $nextMonth = $monthCarbon->copy()->addMonth()->format('Y-m');
        $monthLabel = $monthCarbon->format('m/Y');

        return view('admin.catalog_v1.flashsales.index', compact(
            'weeks',
            'monthLabel',
            'prevMonth',
            'nextMonth',
            'sessions',
            'byDate',
            'countMap',
            'monthCarbon'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        FlashSaleV1::create([
            'sale_date' => $request->sale_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Tạo Flash Sale theo khung giờ thành công');
    }

    public function update(Request $request, $id)
    {
        $fs = FlashSaleV1::findOrFail($id);

        $request->validate([
            'sale_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $fs->update([
            'sale_date' => $request->sale_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'title' => $request->title,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Cập nhật Flash Sale thành công');
    }

    public function destroy($id)
    {
        FlashSaleItemV1::where('flash_sale_id', $id)->delete();
        FlashSaleV1::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Xóa Flash Sale thành công');
    }

    public function items(Request $request, $id)
    {
        $flashSale = FlashSaleV1::findOrFail($id);

        $items = FlashSaleItemV1::query()
            ->where('flash_sale_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $productIds = $items->pluck('product_id')->filter()->values()->all();

        $productsMap = [];
        if (!empty($productIds)) {
            $productsMap = ProductV1::whereIn('id', $productIds)
                ->get()
                ->keyBy('id')
                ->toArray();
        }

        $q = ProductV1::query()->orderBy('id', 'desc');

        if ($request->filled('key_search')) {
            $key = trim($request->key_search);

            $q->where(function ($qq) use ($key) {
                $qq->where('name', 'like', "%{$key}%")
                    ->orWhere('full_name', 'like', "%{$key}%")
                    ->orWhere('code_product_kiovet', 'like', "%{$key}%");
            });
        }

        $listData = $q->paginate(50)->withQueryString();

        $existMap = array_fill_keys($productIds, true);
        return view('admin.catalog_v1.flashsales.items', compact(
            'flashSale',
            'items',
            'productsMap',
            'listData',
            'existMap'
        ));
    }

    public function itemsStore(Request $request, $id)
    {
        $flashSale = FlashSaleV1::findOrFail($id);

        $productIds = $request->get('product_ids', []);
        $data = $request->get('items', []);

        if (!is_array($productIds) || count($productIds) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm.');
        }

        $created = 0;
        $updated = 0;

        foreach ($productIds as $pid) {
            $pid = (int) $pid;

            $flashPrice = $data[$pid]['flash_price'] ?? null;
            $qty = $data[$pid]['quantity'] ?? null;

            if ($flashPrice === null || $flashPrice === '' || $qty === null || $qty === '') {
                continue;
            }

            $product = ProductV1::find($pid);

            if (!$product) {
                continue;
            }

            $defaultName = $product->full_name ?: $product->name;
            $defaultImage = $product->img_avatar;

            $row = FlashSaleItemV1::where('flash_sale_id', $id)
                ->where('product_id', $pid)
                ->first();

            if ($row) {
                $row->update([
                    'item_name' => $row->item_name ?: $defaultName,
                    'item_image' => $row->item_image ?: $defaultImage,
                    'flash_price' => $flashPrice,
                    'quantity' => (int) $qty,
                    'status' => 1,
                ]);

                $updated++;
            } else {
                FlashSaleItemV1::create([
                    'flash_sale_id' => $id,
                    'product_id' => $pid,
                    'item_name' => $defaultName,
                    'item_image' => $defaultImage,
                    'flash_price' => $flashPrice,
                    'quantity' => (int) $qty,
                    'sold' => 0,
                    'status' => 1,
                ]);

                $created++;
            }
        }

        return redirect()->back()->with('success', "Đã thêm {$created} sản phẩm, cập nhật {$updated} sản phẩm vào Flash Sale.");
    }

    public function itemsUpdate(Request $request, $id, $item_id)
    {
        $item = FlashSaleItemV1::where('flash_sale_id', $id)
            ->where('id', $item_id)
            ->firstOrFail();

        $request->validate([
            'item_name' => 'nullable|string|max:255',
            'item_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flash_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sold' => 'nullable|integer|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $data = [
            'item_name' => $request->item_name,
            'flash_price' => $request->flash_price,
            'quantity' => (int) $request->quantity,
            'sold' => (int) ($request->sold ?? 0),
            'status' => $request->status ?? 1,
        ];

        if ($request->hasFile('item_image')) {
            $data['item_image'] = $this->saveFlashSaleItemImage($request->file('item_image'));
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Cập nhật sản phẩm Flash Sale thành công');
    }

    public function itemsDestroy($id, $item_id)
    {
        FlashSaleItemV1::where('flash_sale_id', $id)
            ->where('id', $item_id)
            ->delete();

        return redirect()->back()->with('success', 'Xóa sản phẩm khỏi Flash Sale thành công');
    }

    private function saveFlashSaleItemImage($file)
    {
        $folder = 'upload/flash-sale/items';
        $folderPath = public_path($folder);

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0775, true);
        }

        $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        $file->move($folderPath, $name);

        return $folder . '/' . $name;
    }
}