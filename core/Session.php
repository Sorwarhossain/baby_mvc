<?php

namespace App\Core;

class Session
{

    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $sessionMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($sessionMessages as $key => &$flashMessage){
            // Mark to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $sessionMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct(){
        $sessionMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($sessionMessages as $key => &$flashMessage){
            if($flashMessage['remove']){
                unset($sessionMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $sessionMessages;
    }
}