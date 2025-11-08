<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $products = Product::with('category')->get();
        return $this->successResponse(ProductResource::collection($products));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        return $this->successResponse(new ProductResource($product));
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
             return $this->errorResponse('not found product',404);
        }
        return $this->successResponse(new ProductResource($product));
    }

    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
             return $this->errorResponse('not found product',404);
        }
        $data = $request->validated();
        $product->update($data);
        return $this->successResponse(new ProductResource($product));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
             return $this->errorResponse('not found product',404);
        }
        $product->delete();
        return $this->successResponse([], 'Product deleted');
    }


    public function updateStock(Request $request,$id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

       $product->stock = $product->stock + $request->quantity;
       $product->save();
       return $this->successResponse([
        'product_id' => $product->id,
        'stock' => $product->stock
    ], 'Stock updated successfully');
    }


    public function stock($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse([
            'product_id' => $product->id,
            'stock' => $product->stock
        ]);
    }

}


