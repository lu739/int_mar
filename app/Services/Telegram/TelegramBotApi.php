<?php

namespace App\Services\Telegram;
use App\Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';
    public static function sendMessage(int $chatId, string $token, string $message): bool
    {
        try {
            $response = Http::get(self::HOST . $token . "/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
            ])
                ->throw()
                ->json();

            return $response['ok'] ?? false;
        } catch (\Throwable $e) {
            throw new TelegramBotApiException($e->getMessage());
        }
    }
}
