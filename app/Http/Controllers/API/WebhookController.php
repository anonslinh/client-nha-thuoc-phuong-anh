<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
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

            dd($response->json());
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Webhook hoá đơn
    */
    public function invoiceUpdate(Request $request)
    {
        $secret = base64_decode('winbaby14081995'); // KHÔNG dùng mã hóa Base64 ở đây

        $payload = $request->getContent();
        $signatureFromHeader = $request->header('X-Hub-Signature');
        $generatedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($generatedSignature, $signatureFromHeader)) {
            Log::warning('Webhook invoice.update - Signature mismatch', [
                'expected' => $generatedSignature,
                'received' => $signatureFromHeader,
            ]);
            return response('Unauthorized', 401);
        }

        // ✅ Dữ liệu hợp lệ - xử lý payload
        $data = $request->all();
        Log::info('Webhook invoice.update received', $data);

        // TODO: Ghi log, cập nhật đơn hàng trong DB nếu cần...

        return response('OK', 200);
    }
}
