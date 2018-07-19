<?php

namespace App\Http\Controllers;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

use Illuminate\Http\Request;

use URL;

class PaypalPaymentsController extends Controller
{

    private $apiContext;

    public function __construct()
    {
        $paypal_client_id = config('paypal.client_id');
        $paypal_secret = config('paypal.secret');
        $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $paypal_client_id,
                $paypal_secret)
        );
        $this->apiContext->setConfig(config('paypal.settings'));

    }


    public function payService($monto,$emailEmpresa){

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        /*
        $item = new Item();
        $item->setName('Servicio de grua')
            ->setCurrency('USD')
            ->setQuantity('1')
            ->setPrice($monto);

        $itemList = new ItemList();
        $itemList->setItems(array($item));*/

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($monto);

        $payee = new Payee();
        $payee->setEmail($emailEmpresa);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setPayee($payee)
            ->setDescription("Pago para servicio de grua");

        $redirectUrl = new RedirectUrls();
        $redirectUrl->setReturnUrl(URL::to('/pago/aprovado'))
            ->setCancelUrl(URL::to('/pago/cancelado'));


        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrl)
            ->setTransactions([$transaction]);

        try{
            $payment->create($this->apiContext);
        }
        catch (PayPalConnectionException $e){

            return ['success'=>'false','message'=>'Error al ejecutar el pago. Intentelo mas tarde.','status'=>'500'];
        }
        $aprovalLink = $payment->getApprovalLink();

        return ['success'=>'true','message'=>'Creado pago con PayPal. Usa el link para continuar con el pago','link'=>$aprovalLink,'status'=>'200'];
    }

    public function approved(Request $request){

        $paymentId = $request['paymentId'];

        $payment = Payment::get($paymentId,$this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request['PayerID']);

        $result = $payment->execute($execution, $this->apiContext);


        if ($result->getState() == 'approved'){
            return view('paypal_payment.approved',compact('result',$result));
        }

        return view('paypal_payment.failed',$result);

    }
}
