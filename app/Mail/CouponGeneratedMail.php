<?php

namespace App\Mail;

use App\Models\CouponInstance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF; // assuming you aliased DomPDF as PDF

class CouponGeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    public CouponInstance $instance;

    public function __construct(CouponInstance $instance)
    {
        $this->instance = $instance;
    }

    public function build()
    {
        $pdf = PDF::loadView('pdf.coupon', [
            'coupon' => $this->instance,
        ]);

        return $this->subject("Your WrenchDeals Coupon")
            ->markdown('emails.coupons.generated', [
                'coupon' => $this->instance,
            ])
            ->attachData($pdf->output(), "coupon-{$this->instance->code}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
