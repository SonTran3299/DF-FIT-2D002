<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomerEmailTemplate;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function caculateTotalOrder($carts, int $freeShippingPrice, int $shippingPrice)
    {
        $total = 0;
        $subtotal = 0;
        $shippingFee = 0;
        $discount = 0;
        foreach ($carts as $cart) {
            $subtotal += $cart->product->price * $cart->quantity;
            $discount += $cart->product->price * $cart->product->discount_percentage * $cart->quantity;
        }
        if ($subtotal < $freeShippingPrice) {
            $shippingFee = $shippingPrice;
        }
        $total = $subtotal + $shippingFee - $discount;

        return [
            'total' => $total,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shippingFee' => $shippingFee,
        ];
    }

    public function index()
    {
        $userId = Auth::id();
        $cartQuery = Cart::with(['product' => function ($query) {
            $query->withTrashed();
        }])->where('user_id', $userId);

        $cartItems = $cartQuery->get();

        $cartWithActiveProducts = $cartQuery->whereHas('product', function ($query) {
            $query->where('status', '!=', 0);
        })->get();

        $unactiveCartItems = $cartItems->filter(function ($cartItem) {
            if (!$cartItem->product) {
                return true;
            }
            return $cartItem->product->status === 0 || $cartItem->product->deleted_at !== null;
        });

        $caculatePrice = $this->caculateTotalOrder($cartWithActiveProducts, 500000, 15000);
        return view(
            'client.pages.cart',
            [
                'cart' => $cartWithActiveProducts,
                'caculatePrice' => $caculatePrice,
                'unactiveCartItems' => $unactiveCartItems,
                'unactiveItemCount' => $unactiveCartItems->count()
            ]
        );
    }

    public function addToCart(Product $product)
    {
        $userId = Auth::id();
        $cartItem = Cart::firstOrNew([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);
        $cartItem->quantity += 1;
        $cartItem->save();

        return response()->json(['message' => 'Thêm thành công']);
    }

    public function updateCart(Request $request)
    {
        $userId = Auth::id();
        $cartItemsJson = $request->input('cart_items_data');
        if (empty($cartItemsJson)) {
            return redirect()->back()->with('error', 'Không có dữ liệu giỏ hàng để cập nhật.');
        }
        $cartItems = json_decode($cartItemsJson, true);
        if (!is_array($cartItems)) {
            return redirect()->back()->with('error', 'Dữ liệu giỏ hàng không hợp lệ.');
        }

        try {
            DB::beginTransaction();

            foreach ($cartItems as $item) {
                $cartId = $item['id'];
                $newQuantity = $item['quantity'];

                $cartEntry = Cart::where('id', $cartId)->where('user_id', $userId)->first();

                if ($cartEntry) {
                    if ($newQuantity > $cartEntry->product->stock) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Số lượng sản phẩm "' . $cartEntry->product->name . '" vượt quá tồn kho hiện có (' . $cartEntry->product->stock . '). Vui lòng kiểm tra lại giỏ hàng.');
                    }
                    if ($newQuantity < 1) {
                        $newQuantity = 1;
                    }
                    $cartEntry->quantity = $newQuantity;
                    $cartEntry->save();
                }
            }

            DB::commit();
            return redirect()->route('client.checkout')->with('msg', 'Giỏ hàng đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('smg', 'Đã xảy ra lỗi khi cập nhật giỏ hàng. Vui lòng thử lại.');
        }
    }

    public function addToCartFromDetail(Product $product, Request $request)
    {
        self::insertOrUpdateCart(Auth::id(), $product->id, $request->quantity);
        return redirect()->route('client.cart');
    }
    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())->with('product')->get();
        $caculatePrice = $this->caculateTotalOrder($cart, 500000, 15000);

        return view('client.pages.checkout', [
            'user' => Auth::user(),
            'cart' => $cart,
            'caculatePrice' => $caculatePrice
        ]);
    }

    public function placeOrder(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', $userId)->with('product')->get();

            $caculatePrice = $this->caculateTotalOrder($cart, 500000, 15000);

            $order = new Order();
            $order->user_id = $userId;
            $order->address = $request->address;
            $order->note = $request->note;
            $order->status = 0;
            $order->subtotal = $caculatePrice['subtotal'];
            $order->shipping_fee = $caculatePrice['shippingFee'];
            $order->total = $caculatePrice['total'];
            $order->save(); //insert

            foreach ($cart as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->price = $item->product->price;
                $orderItem->discount_percentage = $item->product->discount_percentage;
                $orderItem->name = $item->product->name;
                $orderItem->quantity = $item->quantity;
                $orderItem->main_image = $item->product->main_image;
                $orderItem->save();
            }

            $orderPaymentMethod = OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'total' => $caculatePrice['total'],
                'status' => 'pending',
            ]);

            //Update phone and address of user
            $user = User::find($userId);
            if ($user) {
                $user->phone = $request->phone;
                $user->address = $request->address;
                $user->save();
            }

            //DB::commit();

            if ($request->payment_method === 'vnpay') {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $startTime = date("YmdHis");
                $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

                $vnp_TxnRef = $order->id;
                $vnp_Amount = (int)($order->total);
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'VNBANK';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                $vnp_HashSecret = env('VNPAY_HASHSECRET');

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNPAY_TMNCODE'),
                    "vnp_Amount" => $vnp_Amount * 100,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => env('VNPAY_RETURNURL'),
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire,
                    "vnp_BankCode" => $vnp_BankCode,
                );

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNPAY_URL') . "?" . $query;

                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                DB::commit();
                return redirect()->to($vnp_Url);
            } else {
                Mail::to('tvs32.ys@gmail.com')->send(new CustomerEmailTemplate($order, $user));
                //Gửi cho admin
                //Mail::to('tvs32.ys@gmail.com')->send(new AdminEmailTemplate($order));

                foreach ($order->orderItems as $orderItem) {
                    $product = Product::find($orderItem->product_id);
                    $product->stock -= $orderItem->quantity;
                    $product->save();
                }
            }
            $check = Cart::where('user_id', $userId)->delete();
            DB::commit();
            return redirect()->route('client.order-history')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
        }
    }

    public function deleteProductFromCart(Cart $product)
    {
        $msg = $product->delete() ? 'Thành công' : 'Thất bại';
        return redirect()->route('client.cart');
    }

    public function cartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->count('product_id');

        return response()->json(['count' => $cartCount]);
    }

    public static function insertOrUpdateCart(int|string $userId, int|string $productId, int|string $quantity): void
    {
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }

    public function vnpayReturn(Request $request)
    {
        $data = $request->all();
        $inputData = array();

        foreach ($request->query() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $user = Auth::user(); // Có thể null nếu session mất
        $userId = $user ? $user->id : null; // Lấy ID nếu có

        $orderId = $request->vnp_TxnRef;
        $order = Order::find($orderId);
        $orderPaymentMethod = OrderPaymentMethod::where('order_id', $orderId)->first();
        if (!$order || !$orderPaymentMethod) {
            return redirect()->route('client.cart')->with('error', 'Không tìm thấy thông tin đơn hàng. Vui lòng kiểm tra lại.');
        }

        DB::beginTransaction();
        try {
            if ($secureHash == $request->vnp_SecureHash) {
                if ($request->vnp_ResponseCode == '00') {
                    $orderPaymentMethod->status = 'đã thanh toán';
                    $orderPaymentMethod->save();

                    foreach ($order->orderItems as $orderItem) {
                        $product = Product::find($orderItem->product_id);
                        if ($product) {
                            $product->stock -= $orderItem->quantity;
                            $product->save();
                        }
                    }

                    $check = Cart::where('user_id', $user->id)->delete();

                    if ($user) {
                        Mail::to('tvs32.ys@gmail.com')->send(new CustomerEmailTemplate($order, $user));
                    }

                    DB::commit();
                    // return view('vnpay.vnpay-return', ['data' => $data, 'secureHash' => $secureHash]);
                    return redirect()->route('client.order-history')->with('success', 'Thanh toán thành công!');
                } else {
                    $orderPaymentMethod->status = 'thất bại';
                    $orderPaymentMethod->save();

                    DB::commit();

                    return redirect()->route('client.order-history')
                        ->with('error', 'Thanh toán VNPAY thất bại. Vui lòng thử lại hoặc chọn phương thức khác.');
                }
            } else {
                $orderPaymentMethod->status = 'Lỗi';
                $orderPaymentMethod->save();

                DB::commit();
                return redirect()->route('client.order-history')
                    ->with('error', 'Lỗi xác thực thanh toán. Vui lòng liên hệ hỗ trợ.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('client.order-history')
                ->with('error', 'Có lỗi khi xử lý thanh toán. Vui lòng liên hệ hỗ trợ.');
        }
    }
}
