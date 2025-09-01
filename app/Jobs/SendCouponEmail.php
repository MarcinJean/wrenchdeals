<?php

namespace App\Jobs;

use App\Mail\CouponGeneratedMail;
use App\Models\CouponInstance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendCouponEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $code;
    protected ?string $email;

    public function __construct(string $code, ?string $email)
    {
        $this->code  = $code;
        $this->email = $email;
    }

    public function handle()
    {
        $instance = CouponInstance::where('code', $this->code)->firstOrFail();
        Mail::to($this->email)->send(new CouponGeneratedMail($instance));
    }
}
