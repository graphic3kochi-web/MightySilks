<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** The shopper's order confirmation, sent at checkout with the PDF invoice attached. */
class OrderPlaced extends Mailable
{
    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        $store = Setting::get('store_name');

        return new Envelope(
            replyTo: [new Address(Setting::get('contact_email'), $store)],
            subject: "$store order #{$this->order->number} confirmed — your invoice",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.order-placed');
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->order->invoicePdf()->output(), $this->order->invoiceFilename())->withMime('application/pdf'),
        ];
    }
}
