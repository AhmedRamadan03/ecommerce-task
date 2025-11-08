<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $orders = Order::with('items')->where('user_id', $request->user['id'])->get();
        return $this->successResponse(OrderResource::collection($orders));
    }

    public function store(StoreOrderRequest $request)
    {
        $items = $request->validated()['items'];
        $total = 0;

        foreach ($items as $item) {
            $productResponse = Http::get("http://product-service:9000/api/products/{$item['product_id']}");
            if ($productResponse->failed()) {
                return $this->errorResponse("Product ID {$item['product_id']} not found", 404);
            }

            $productData = $productResponse->json()['data'];

            if ($item['quantity'] > $productData['stock']) {
                return $this->errorResponse("Insufficient stock for product {$productData['name']}", 400);
            }

            $total += $productData['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => $request->user['id'],
            'status' => 'Pending',
            'total' => $total,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $productData['price'],
            ]);

            Http::patch("http://product-service:9000/api/products/{$item['product_id']}/update-stock", [
                'quantity' => $item['quantity'] * -1
            ]);
        }

        return $this->successResponse(new OrderResource($order), "Order placed successfully");
    }

    public function allOrders()
    {
        $orders = Order::with('items')->get();
        return $this->successResponse(OrderResource::collection($orders));
    }

    public function updateStatus(UpdateStatusRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return $this->successResponse(new OrderResource($order), "Order status updated");
    }
}
