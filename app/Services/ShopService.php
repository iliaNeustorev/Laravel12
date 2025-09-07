<?php 

namespace App\Services;

class ShopService 
{
    public function transformDataForSavePrice(array $data): array
    {
        if (! empty($data)) {
            return collect($data)
                ->mapWithKeys(fn (array $product) => [$product['id'] => ['price' => $product['price'] ?? null]])
                ->toArray();
        }
        return [];
    }
}