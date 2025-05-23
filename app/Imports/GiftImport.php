<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Gift;
use App\Models\GiftInventories;
use App\Services\KiotVietService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use function PHPSTORM_META\map;

class GiftImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $helper;

    public function __construct(KiotVietService $helper)
    {
        $this->helper = $helper;
    }

    public function model(array $row)
    {
        if(empty($row['ten']) || empty($row['ma']) || empty($row['diem_quy_doi'])){
            return null;
        }
        $image = null;
        if(isset($row['hinh_anh'])){
            $image = $this->helper->saveImage($row['hinh_anh'],'gift');
        }
        $product = $this->helper->detailProduct($row['ma']);
        $dataGift = Gift::where('code', $row['ma'])->first();
        if(isset($dataGift)){
            $dataGift->name = $row['ten'];
            $dataGift->points_required = $row['diem_quy_doi'];
            $dataGift->save();
        }else{
            $dataGift = new Gift([
                'name' => $row['ten'],
                'code' => $row['ma'],
                'image' => $image,
                'description' => $row['mo_ta']??null,
                'is_display' => 1,
                'points_required' => $row['diem_quy_doi']
            ]);
            $dataGift->save();
        }
        GiftInventories::where('gift_id', $dataGift['id'])->delete();
        foreach ($product as $value){
            foreach ($value['inventories'] as $item){
                $branch = Branch::where('kiotviet_id', $item['branchId'])->first();
                if(isset($branch)){
                    $quantity = new GiftInventories([
                        'gift_id' => $dataGift['id'],
                        'branch_id' => $branch->id,
                        'quantity' => round($item['onHand'])
                    ]);
                    $quantity->save();
                }
            }
        }
    }
}
