<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $message = 'Admin logged in from IP: ' . $request->ip() . '. ' . now();

            // dd($message);

            Telegram::sendMessage([
                'chat_id' => 865568036,
                'text' => $message,
            ]);
        }
        return $next($request);
    }
}
