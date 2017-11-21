<?php

namespace TwoFASLight\TOTP;

use Endroid\QrCode\QrCode;
use TwoFASLight\TwoFASLight_App;

class TwoFASLight_TOTP
{
    /**
     * @var \TwoFASLight\User\TwoFASLight_User
     */
    private $user;

    /**
     * @var \TwoFASLight\Option\TwoFASLight_Option
     */
    private $option;

    /**
     * Length of secret
     */
    private $totp_secret_length = 16;

    /**
     * Interval between key regeneration
     */
    private $key_regeneration = 30;

    /**
     * Length of the Token generated
     */
    private $totp_token_length = 6;

    /**
     * Lookup needed for Base32 encoding
     */
    private $alphabet = array(
        "A" => 0, "B" => 1,
        "C" => 2, "D" => 3,
        "E" => 4, "F" => 5,
        "G" => 6, "H" => 7,
        "I" => 8, "J" => 9,
        "K" => 10, "L" => 11,
        "M" => 12, "N" => 13,
        "O" => 14, "P" => 15,
        "Q" => 16, "R" => 17,
        "S" => 18, "T" => 19,
        "U" => 20, "V" => 21,
        "W" => 22, "X" => 23,
        "Y" => 24, "Z" => 25,
        "2" => 26, "3" => 27,
        "4" => 28, "5" => 29,
        "6" => 30, "7" => 31
    );


    /**
     * TwoFASLight_TOTP constructor.
     *
     * @param TwoFASLight_App $app
     */
    public function __construct(TwoFASLight_App $app)
    {
        $this->user = $app->get_user();
        $this->option = $app->get_options();
    }

    /**
     * @param $totp_secret
     * @param $totp_token
     *
     * @return bool
     */
    public function check_code($totp_secret, $totp_token)
    {
        try {
            $valid_token = ($totp_token === $this->generate_token($totp_secret, current_time('timestamp', true)));
            $valid_token |= ($totp_token === $this->generate_token($totp_secret, current_time('timestamp', true) - 30));
        } catch (\LogicException $e) {
            return false;
        }
        
        return $this->validate_totp_secret($totp_secret) &&
            $this->validate_totp_token($totp_token) &&
            $valid_token;
    }

    /**
     * @param $totp_secret
     *
     * @return bool
     */
    public function validate_totp_secret($totp_secret)
    {
        return is_string($totp_secret) && preg_match("/[A-Z0-9]{16}/", $totp_secret) === 1;
    }

    /**
     * @param $totp_token
     *
     * @return bool
     */
    public function validate_totp_token($totp_token)
    {
        return is_string($totp_token) && preg_match("/[0-9]{6}/", $totp_token) === 1;
    }


    /**
     * Generates a 16 digit secret key in base32 format
     *
     * @return string
     */
    public function generate_totp_secret()
    {
        $secret = "";
        $alphabet = "234567QWERTYUIOPASDFGHJKLZXACVBNM";
        $length = 16;

        while (strlen($secret) < $length) {
            $secret .= substr(str_shuffle($alphabet), -1);
        }

        return $secret;
    }
    
    /**
     * @param  string $secret
     * @return string
     */
    public function generate_qr_code($secret)
    {
        
        // TOTP metadata
        $endroid_qr_code = new QrCode();
        $blog_name         = urlencode(get_option('blogname', 'WordPress Account'));
        $user              = wp_get_current_user();
        $user_email        = $user->user_email;
        $description       = urlencode('WordPress Account');
        $site_url          = get_option('siteurl');
        $size              = 300;

        if ($site_url) {
            $parsed = parse_url($site_url);

            if (isset($parsed['host'])) {
                $description = $parsed['host'];
            }
        }

        $message = "otpauth://totp/{$description}:$user_email?secret={$secret}&issuer={$blog_name}";

        $endroid_qr_code
            ->setText($message)
            ->setSize($size)
            ->setErrorCorrection('high');

        return $endroid_qr_code->getDataUri();
    }


    /**
     * @param $totp_secret
     * @param $timestamp
     *
     * @return string
     */
    public function generate_token($totp_secret, $timestamp)
    {
        $binaryKey = $this->base32Decode($totp_secret);
        $counter = $this->getCounter($timestamp);
        $code    = $this->oathHotp($binaryKey, $counter);
        return (string) $code;
    }
    
    /**
     * Returns the floating Unix Timestamp (+/- 2m) divided by the keyRegeneration period.
     *
     * @param int $timestamp
     *
     * @return integer
     */
    private function getCounter($timestamp)
    {
        return floor($timestamp / $this->key_regeneration);
    }

    /**
     * Decodes a base32 string into a binary string.
     *
     * @param string $b32
     *
     * @return string (binary)
     *
     * @throws \LogicException
     */
    private function base32Decode($b32)
    {
        $b32 = strtoupper($b32);
        if (!preg_match('/^[234567QWERTYUIOPASDFGHJKLZXCVBNM]{' . $this->totp_secret_length . '}$/', $b32)) {
            throw new \LogicException;
        }
        $l      = strlen($b32);
        $n      = 0;
        $j      = 0;
        $binary = "";
        for ($i = 0; $i < $l; $i++) {

            $n = $n << 5;                // Move buffer left by 5 to make room
            $n = $n + $this->alphabet[$b32[$i]];    // Add value into buffer
            $j = $j + 5;                // Keep track of number of bits in buffer

            if ($j >= 8) {
                $j = $j - 8;
                $binary .= chr(($n & (0xFF << $j)) >> $j);
            }
        }
        return $binary;
    }

    /**
     * Takes the secret key and the timestamp and returns the one time
     * password.
     *
     * @param string (binary) $key - Secret key in binary form.
     * @param integer         $counter - Timestamp as returned by get_timestamp.
     *
     * @return string
     * @throws \LogicException
     */
    private function oathHotp($key, $counter)
    {
        if (strlen($key) < 8) {
            throw new \LogicException;
        }
        $bin_counter = pack('N*', 0) . pack('N*', $counter); // Counter must be 64-bit int
        $hash        = hash_hmac('sha1', $bin_counter, $key, true);
        return str_pad($this->oathTruncate($hash), $this->totp_token_length, '0', STR_PAD_LEFT);
    }

    /**
     * Extracts the OTP from the SHA1 hash.
     *
     * @param string (binary) $hash
     *
     * @return integer
     */
    private function oathTruncate($hash)
    {
        $offset = ord($hash[19]) & 0xf;
        return (
            ((ord($hash[$offset + 0]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        ) % pow(10, $this->totp_token_length);
    }

}
