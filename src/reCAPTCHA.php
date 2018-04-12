<?php
/**
 * Google reCAPTCHA class
 */

class reCAPTCHA
{
    protected $siteKey;
    protected $secretKey;

    protected $response;
    protected $siteVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(string $siteKey = CAPTCHA_SITE_KEY, string $secretKey = CAPTCHA_SECRET_KEY)
    {
        $this->setCredentials($siteKey, $secretKey);
    }

    public function setCredentials(string $siteKey, string $secretKey)
    {
        $this->siteKey   = $siteKey;
        $this->secretKey = $secretKey;
    }

    public function checkResponse(string $response)
    {
        if (!$response)
            return false;

        $param = array(
            'secret'   => $this->secretKey,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->siteVerifyUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $json = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($json);

        if ($obj->success == false)
            return false;

        return true;
    }
}