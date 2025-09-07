<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shop\SaveRequest;
use App\Models\Product;
use App\Models\Shop;
use App\Services\ShopService;

class ShopController extends Controller
{

    /**
     *
     * @param ShopService $shopService
     */
    public function __construct(public ShopService $shopService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = Shop::orderByDesc('id')->get();
        return view('shops/index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::pluck('title', 'id');
        return view('shops/create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRequest $request)
    {
        $data = $request->validated();
        $shop = Shop::create($data);
        $products = $this->shopService->transformDataForSavePrice($data['products'] ?? []);
        if (! empty($products)) {
            $shop->products()->attach($products);
        }
        return redirect()->route('shops.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        $shop->load('products');
        return view('shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        $shop->load('products');
        $products = Product::pluck('title', 'id');
        return view('shops/edit', compact('products', 'shop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRequest $request, Shop $shop)
    {
        $data = $request->validated();
        $shop->update($data);
        $products = $this->shopService->transformDataForSavePrice($data['products'] ?? []);
        if (! empty($products)) {
            $shop->products()->sync($products);
        }
        return redirect()->route('shops.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->products()->detach();
        $shop->delete();
        return redirect()->route('shops.index');
    }

    /**
     *
     * @param Shop $shop
     * @return RedirectResponse
     */
    public function detachAllProducts(Shop $shop)
    {
        $shop->products()->detach();
        return redirect()->route('shops.show', $shop->id);
    }
}
