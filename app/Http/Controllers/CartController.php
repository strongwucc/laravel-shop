<?php

namespace App\Http\Controllers;


use App\Http\Requests\AddCartRequest;
use App\Http\Requests\Request;
use App\Models\ProductSku;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add (AddCartRequest $request)
    {

        $this->cartService->add($request->input('sku_id'), $request->input('amount'));

        return [];
    }

    public function index (Request $request)
    {
        $cartItems = $this->cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        return view('cart.index', compact('cartItems', 'addresses'));
    }

    public function remove (ProductSku $sku)
    {
        $this->cartService->remove($sku->id);
        return [];
    }
}
