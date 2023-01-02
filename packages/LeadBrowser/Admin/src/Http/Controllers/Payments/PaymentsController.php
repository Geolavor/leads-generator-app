<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\Payments;

use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Sales\Repositories\OrderRepository;
use Illuminate\Support\Arr;

class PaymentsController extends Controller
{
     /**
     *
     * @return void
     */
    public function __construct(protected OrderRepository $orderRepository)
    {
        // 
    }

    public function index()
    {
        return view('admin::payments.create');
    }

    /**
     * Display a create.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::payments.create');
    }

    public function store()
    {

        $registration_request = app()->make(\Devpark\Transfers24\Requests\Transfers24::class);
        $register_payment = $registration_request->setEmail('test@example.com')->setAmount(100)->init();

        if($register_payment->isSuccess())
        {
            // save registration parameters in payment object
            
            return $registration_request->execute($register_payment->getToken(), true);
        }

        return;


        // $item = '';

        // if ($redirectUrl = Payment::getRedirectUrl($item)) {
        //     return response()->json([
        //         'success'      => true,
        //         'redirect_url' => $redirectUrl,
        //     ]);
        // }

        $data = [
            'customer_id' => 1,
            'is_guest' => 1,
            'customer_email' => 'test@test.com',
            'customer_first_name' => 1,
            'customer_last_name' => 1,
            'items_count' => 1,
            'items_qty' => 1,
            'base_currency_code' => 1,
            'channel_currency_code' => 1,
            'order_currency_code' => 1,
            'grand_total' => 1,
            'base_grand_total' => 1,
            'sub_total' => 1,
            'base_sub_total' => 1,
            'tax_amount' => 1,
            'base_tax_amount' => 1,
            'coupon_code' => 1,
            'discount_amount' => 1,
            'base_discount_amount' => 1,
            'billing_address' => 1,
            'payment' => [
                'id'            => 1,
                'order_id'      => 7,
                'additional'    => 'test',
                'method'        => 'moneytransfer',
                'method_title'  => 'moneytransfer'
            ],
            'items' => [
                [
                    'sku'          => 1,
                    'type'         => 1,
                    'name'         => 'test',
                    'coupon_code'  => 1
                ]
            ]
        ];

        $prepared_data = $this->prepareDataForOrder($data);

        // dd($prepared_data);

        $order = $this->orderRepository->create($prepared_data);
    }

    /**
     * Prepare data for order.
     *
     * @return array
     */
    public function prepareDataForOrder($data): array
    {
        $finalData = [
            'customer_id'           => $data['customer_id'],
            'is_guest'              => $data['is_guest'],
            'customer_email'        => $data['customer_email'],
            'customer_first_name'   => $data['customer_first_name'],
            'customer_last_name'    => $data['customer_last_name'],
            'customer'              => auth()->guard()->check() ? auth()->guard()->user() : null,
            'total_item_count'      => $data['items_count'],
            'total_qty_ordered'     => $data['items_qty'],
            'base_currency_code'    => $data['base_currency_code'],
            'channel_currency_code' => $data['channel_currency_code'],
            'order_currency_code'   => $data['order_currency_code'],
            'grand_total'           => $data['grand_total'],
            'base_grand_total'      => $data['base_grand_total'],
            'sub_total'             => $data['sub_total'],
            'base_sub_total'        => $data['base_sub_total'],
            'tax_amount'            => $data['tax_amount'],
            'base_tax_amount'       => $data['base_tax_amount'],
            'coupon_code'           => $data['coupon_code'],
            'discount_amount'       => $data['discount_amount'],
            'base_discount_amount'  => $data['base_discount_amount'],
            'billing_address'       => $data['billing_address'],
            'payment'               => $data['payment']
        ];

        foreach ($data['items'] as $item) {
            $finalData['items'][] = $this->prepareDataForOrderItem($item);
        }

        if ($finalData['payment']['method'] === 'paypal_smart_button') {
            $finalData['payment']['additional'] = request()->get('orderData');
        }

        return $finalData;
    }

    /**
     * Prepares data for order item.
     *
     * @param  array  $data
     * @return array
     */
    public function prepareDataForOrderItem($data): array
    {
        $locale = ['locale' => 'pl'];//['locale' => core()->getCurrentLocale()->iso2];

        $finalData = [
            'product'              => 1,//$this->productRepository->find($data['product_id']),
            'sku'                  => $data['sku'],
            'type'                 => $data['type'],
            'name'                 => $data['name'],
            // 'weight'               => $data['weight'],
            // 'total_weight'         => $data['total_weight'],
            // 'qty_ordered'          => $data['quantity'],
            // 'price'                => $data['price'],
            // 'base_price'           => $data['base_price'],
            // 'total'                => $data['total'],
            // 'base_total'           => $data['base_total'],
            // 'tax_percent'          => $data['tax_percent'],
            // 'tax_amount'           => $data['tax_amount'],
            // 'base_tax_amount'      => $data['base_tax_amount'],
            // 'discount_percent'     => $data['discount_percent'],
            // 'discount_amount'      => $data['discount_amount'],
            // 'base_discount_amount' => $data['base_discount_amount'],
            // 'additional'           => is_array($data['additional']) ? array_merge($data['additional'], $locale) : $locale,
        ];

        if (isset($data['children']) && $data['children']) {
            foreach ($data['children'] as $child) {
                /**
                 * - For bundle, child quantity will not be zero.
                 *
                 * - For configurable, parent one will be added as child one is zero.
                 *
                 * - In testing phase.
                 */
                $child['quantity'] = $child['quantity'] ? $child['quantity'] * $data['quantity'] : $data['quantity'];

                $finalData['children'][] = $this->prepareDataForOrderItem($child);
            }
        }

        return $finalData;
    }

    /**
     * 
     */
    public function callback()
    {
        $payment_verify = app()->make(\Devpark\Transfers24\Requests\Transfers24::class);
        $payment_response = $payment_verify->receive(request());

        if ($payment_response->isSuccess()) {

            // $payment = Payment::where('session_id',$payment_response->getSessionId())->firstOrFail();
           // process order here after making sure it was real payment
           dd($payment_response);
        }
        echo "OK";
    }
}
