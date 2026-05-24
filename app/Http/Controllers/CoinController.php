<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoinController extends Controller
{
    public function getPrice(Request $request)
    {
        $symbol = strtoupper(trim($request->input('symbol')));
        
        if (empty($symbol)) {
            return response()->json(['error' => 'Token tidak ditemukan'], 404);
        }

        // Append USDT if not provided, assuming user wants the USD pair
        if (!str_ends_with($symbol, 'USDT') && !str_ends_with($symbol, 'BUSD') && !str_ends_with($symbol, 'USDC')) {
            $symbol .= 'USDT';
        }

        $url = "https://api.binance.com/api/v3/ticker/24hr?symbol={$symbol}";

        try {
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Token tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal terhubung ke Binance API'], 500);
        }
    }
}
