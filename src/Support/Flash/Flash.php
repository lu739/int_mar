<?php

namespace Support\Flash;

use Illuminate\Contracts\Session\Session;

class Flash
{
    private const MESSAGE_KEY = 'int_mar_flash_message';
    private const MESSAGE_CLASS_KEY = 'int_mar_flash_class';

    public function __construct(protected Session $session)
    {
    }

    public function get(): ?FlashMessage
    {
        $message = $this->session->get(self::MESSAGE_KEY);

        if (!$message) {
            return null;
        }

        return new FlashMessage($message, $this->session->get(self::MESSAGE_CLASS_KEY, ''));
    }

    public function info(string $message): void
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::MESSAGE_CLASS_KEY, 'bg-purple text-center text-white');
    }
    public function alert(string $message): void
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::MESSAGE_CLASS_KEY, 'bg-pink text-center text-white');
    }
}
