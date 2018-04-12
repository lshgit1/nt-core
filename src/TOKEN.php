<?php
/**
 * Token Class
 */

class TOKEN
{
    protected $token;
    protected $sessionName;

    public function __construct()
    {
        $this->token = '';
    }

    public function setSessionName(string $name)
    {
        $this->sessionName = $name;
    }

    public function getToken(string $name = 'ss_token', int $length = NT_TOKEN_LENGTH)
    {
        if ($name)
            $this->setSessionName($name);

        $key = randomChar($length);

        $enc = new STRENCRYPT();
        $this->token = $enc->encrypt($key);

        $_SESSION[$this->sessionName] = $this->token;

        return $this->token;
    }

    public function verifyToken(string $token, bool $unset = true, string $name = 'ss_token')
    {
        if (!$token)
            return false;

        if ($name)
            $this->setSessionName($name);

        if ($token !== $_SESSION[$this->sessionName])
            return false;

        if ($unset === true)
            unset($_SESSION[$this->sessionName]);

        return true;
    }
}