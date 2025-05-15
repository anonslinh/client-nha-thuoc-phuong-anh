<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\API\HomeController;

class WebhookController extends HelperApiController
{
    /**
     * Đăng ký webhook
    */
    public function registerWebhook(Request $request){
        try{
            $secret = 'winbaby14081995'; // Ít nhất 8 ký tự
            $secretBase64 = base64_encode($secret); // Mã hóa
            $token = $request->token;
            $type = $request->type;
            $url = $request->url;
            $description = $request->description;

            $response = Http::withToken($token)
                ->post('https://public.kiotapi.com/webhooks', [
                    'Webhook' => [
                        'Type' => $type,
                        'Url' => $url,
                        'IsActive' => true,
                        'Description' => $description,
                        'Secret' => $secretBase64
                    ]
                ]);

            return response($response, 200);
        }catch (\Exception $exception){
            Log::info('Webhook register.webhook error', $exception->getMessage());
        }
    }

    /**
     * Webhook khách hàng
     * customer.update
    */
    public function customerUpdateWebhook(Request $request)
    {
        try{
            $payload_data = $request->all();
            foreach ($payload_data['Notifications'] as $payload_datum){
                foreach ($payload_datum['Data'] as $datum){
                    $phone = $this->normalizePhone($datum['ContactNumber']);

                    $this->syncCustomerInvoices($phone);
                }
            }
            return response('OK', 200);
        }catch (\Exception $exception){
            Log::info('Webhook customer.update error', $exception->getMessage());
        }
    }
}
