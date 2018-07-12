<?php

namespace App\Http\Controllers;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use Config;

class PaypalPaymentsController extends Controller
{
    /*
    private $_api_context;

    public function __construct()
    {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    */

    public function payService($monto,$emailEmpresa){

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Servicio de grua')
            ->setCurrency('USD')
            ->setQuantity('1')
            ->setPrice($monto);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($monto);

        $payee = new Payee();
        $payee->setEmail($emailEmpresa);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setPayee($payee)
            ->setDescription('Pago para servicio de grua')
            ->setInvoiceNumber(uniqid());

        $baseUrl = env('APP_URL');
    }
}
