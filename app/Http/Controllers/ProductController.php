<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        try {
            $products = $this->product;
            $allProduct = $products->where([['deleted_at',null],['status','active']])->paginate(8);
            return view('pages.member.products.index', compact('allProduct'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'An error occurred while fetching products.');
        }
    }
}
