<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;
    public $purpose;

    public function __construct($otp, $name = null, $purpose = 'Login')
    {
        $this->otp = $otp;
        $this->name = $name;
        $this->purpose = $purpose;
    }

    public function build()
    {
        return $this->subject("Your OTP code for ECA Adda ({$this->purpose})")
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'name' => $this->name,
                        'purpose' => $this->purpose,
                    ]);
    }
}
?>