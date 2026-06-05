<?php

namespace App\Services;

use App\Models\ProductV1;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductPriceV1Service
{
    protected string $flashSaleTable = 'flash_sales_v1';
    protected string $flashSaleItemTable = 'flash_sale_items_v1';

    public function resolve(int $productId): array
    {
        $product = ProductV1::query()->find($productId);

        if (!$product) {
            return $this->emptyPrice();
        }

        return $this->resolveForProduct($product);
    }

    public function resolveForProduct(ProductV1 $product): array
    {
        $basePrice = $this->getProductBasePrice($product);
        $normalSalePrice = $this->getProductSalePrice($product);

        $flashSalePriceInfo = $this->getActiveFlashSalePrice((int) $product->id);

        if ($flashSalePriceInfo && $flashSalePriceInfo['price'] > 0) {
            $displayPrice = (float) $flashSalePriceInfo['price'];
            $originalPrice = $basePrice > 0 ? $basePrice : null;

            return [
                'display_price' => $displayPrice,
                'original_price' => $originalPrice,
                'is_flash_sale' => true,
                'flash_sale_id' => $flashSalePriceInfo['flash_sale_id'],
                'discount_percent' => $this->calcDiscountPercent((float) $originalPrice, $displayPrice),
            ];
        }

        if ($normalSalePrice > 0 && $basePrice > 0 && $normalSalePrice < $basePrice) {
            return [
                'display_price' => $normalSalePrice,
                'original_price' => $basePrice,
                'is_flash_sale' => false,
                'flash_sale_id' => null,
                'discount_percent' => $this->calcDiscountPercent($basePrice, $normalSalePrice),
            ];
        }

        if ($normalSalePrice > 0 && $basePrice <= 0) {
            return [
                'display_price' => $normalSalePrice,
                'original_price' => null,
                'is_flash_sale' => false,
                'flash_sale_id' => null,
                'discount_percent' => 0,
            ];
        }

        return [
            'display_price' => $basePrice,
            'original_price' => null,
            'is_flash_sale' => false,
            'flash_sale_id' => null,
            'discount_percent' => 0,
        ];
    }

    public function applyToProduct(ProductV1 $product): ProductV1
    {
        $priceInfo = $this->resolveForProduct($product);

        $product->display_price = $priceInfo['display_price'];
        $product->original_price = $priceInfo['original_price'];
        $product->is_flash_sale = $priceInfo['is_flash_sale'];
        $product->flash_sale_id = $priceInfo['flash_sale_id'];
        $product->discount_percent = $priceInfo['discount_percent'];

        return $product;
    }

    protected function getActiveFlashSalePrice(int $productId): ?array
    {
        if (!Schema::hasTable($this->flashSaleTable) || !Schema::hasTable($this->flashSaleItemTable)) {
            return null;
        }

        $itemFlashSaleIdColumn = $this->firstExistingColumn($this->flashSaleItemTable, [
            'flash_sale_id',
            'id_flash_sale_v1',
            'id_flash_sale',
        ]);

        $itemProductIdColumn = $this->firstExistingColumn($this->flashSaleItemTable, [
            'id_product_v1',
            'product_v1_id',
            'product_id',
            'id_product',
        ]);

        $itemPriceColumn = $this->firstExistingColumn($this->flashSaleItemTable, [
            'flash_price',
            'flash_sale_price',
            'sale_price',
            'price_sale',
            'discount_price',
            'price',
        ]);

        if (!$itemFlashSaleIdColumn || !$itemProductIdColumn || !$itemPriceColumn) {
            return null;
        }

        $query = DB::table($this->flashSaleItemTable . ' as fsi')
            ->join($this->flashSaleTable . ' as fs', 'fs.id', '=', 'fsi.' . $itemFlashSaleIdColumn)
            ->where('fsi.' . $itemProductIdColumn, $productId)
            ->where('fsi.' . $itemPriceColumn, '>', 0);

        $this->applyActiveFilter($query, 'fsi', $this->flashSaleItemTable);
        $this->applyActiveFilter($query, 'fs', $this->flashSaleTable);
        $this->applyDateFilter($query, 'fs', $this->flashSaleTable);

        $flashSaleItem = $query
            ->select([
                'fs.id as flash_sale_id',
                DB::raw('fsi.' . $itemPriceColumn . ' as flash_sale_price'),
            ])
            ->orderBy('fsi.' . $itemPriceColumn, 'asc')
            ->first();

        if (!$flashSaleItem) {
            return null;
        }

        return [
            'flash_sale_id' => $flashSaleItem->flash_sale_id,
            'price' => (float) $flashSaleItem->flash_sale_price,
        ];
    }

    protected function applyActiveFilter($query, string $alias, string $table): void
    {
        $activeColumn = $this->firstExistingColumn($table, [
            'is_active',
            'status',
            'active',
        ]);

        if (!$activeColumn) {
            return;
        }

        $qualifiedColumn = $alias . '.' . $activeColumn;

        $query->where(function ($q) use ($qualifiedColumn) {
            $q->whereNull($qualifiedColumn)
                ->orWhereIn($qualifiedColumn, [1, '1', 'active', 'ACTIVE']);
        });
    }

    protected function applyDateFilter($query, string $alias, string $table): void
    {
        $startColumn = $this->firstExistingColumn($table, [
            'start_time',
            'time_start',
            'start_date',
            'date_start',
            'from_date',
        ]);

        $endColumn = $this->firstExistingColumn($table, [
            'end_time',
            'time_end',
            'end_date',
            'date_end',
            'to_date',
        ]);

        if ($startColumn) {
            $query->where(function ($q) use ($alias, $startColumn) {
                $q->whereNull($alias . '.' . $startColumn)
                    ->orWhere($alias . '.' . $startColumn, '<=', now());
            });
        }

        if ($endColumn) {
            $query->where(function ($q) use ($alias, $endColumn) {
                $q->whereNull($alias . '.' . $endColumn)
                    ->orWhere($alias . '.' . $endColumn, '>=', now());
            });
        }
    }

    protected function getProductBasePrice(ProductV1 $product): float
    {
        foreach (['price', 'base_price', 'retail_price', 'original_price'] as $column) {
            if (isset($product->{$column}) && (float) $product->{$column} > 0) {
                return (float) $product->{$column};
            }
        }

        return 0;
    }

    protected function getProductSalePrice(ProductV1 $product): float
    {
        foreach (['price_sale', 'sale_price', 'discount_price'] as $column) {
            if (isset($product->{$column}) && (float) $product->{$column} > 0) {
                return (float) $product->{$column};
            }
        }

        return 0;
    }

    protected function firstExistingColumn(string $table, array $columns): ?string
    {
        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                return $column;
            }
        }

        return null;
    }

    protected function calcDiscountPercent(?float $originalPrice, float $displayPrice): int
    {
        if (!$originalPrice || $originalPrice <= 0 || $displayPrice <= 0 || $displayPrice >= $originalPrice) {
            return 0;
        }

        return (int) round((($originalPrice - $displayPrice) / $originalPrice) * 100);
    }

    protected function emptyPrice(): array
    {
        return [
            'display_price' => 0,
            'original_price' => null,
            'is_flash_sale' => false,
            'flash_sale_id' => null,
            'discount_percent' => 0,
        ];
    }
}
