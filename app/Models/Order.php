<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Guarded(['id'])]
class Order extends Model
{
    /** Fulfilment steps in order; cancelled sits outside them. */
    public const STATUSES = ['placed' => 'Placed', 'packed' => 'Packed', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];

    public const PAYMENT_STATUSES = ['pending' => 'Pending', 'paid' => 'Paid', 'refunded' => 'Refunded'];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'shipping' => 'decimal:2',
            'total' => 'decimal:2',
            'packed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customerName(): string
    {
        return trim("$this->first_name $this->last_name");
    }

    public function itemCount(): int
    {
        return (int) $this->items->sum('qty');
    }

    /** "INV-MS123456": one invoice per order, numbered after it. */
    public function invoiceNumber(): string
    {
        return 'INV-'.$this->number;
    }

    public function invoiceFilename(): string
    {
        return "Mighty-Silks-Invoice-{$this->number}.pdf";
    }

    /** The A4 PDF invoice (resources/views/invoices/order.blade.php): emailed at checkout and downloadable. */
    public function invoicePdf(): \Barryvdh\DomPDF\PDF
    {
        // Font subsetting embeds only the glyphs used, keeping the PDF small enough to email.
        return Pdf::loadView('invoices.order', ['order' => $this->loadMissing('items')])
            ->setPaper('a4')->setOption('isFontSubsettingEnabled', true);
    }

    /** The order as js/main.js keeps it (/order-details, /track-order). */
    public function toRecord(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->created_at->toIso8601String(),
            'status' => $this->status,
            'items' => $this->items->map(fn (OrderItem $item) => [
                'id' => $item->product_code,
                'name' => $item->name,
                'price' => (float) $item->price,
                'image' => $item->image,
                'qty' => $item->qty,
            ])->all(),
            'coupon' => $this->coupon_code,
            'subtotal' => (float) $this->subtotal,
            'discount' => (float) $this->discount,
            'shipping' => (float) $this->shipping,
            'total' => (float) $this->total,
            'shippingMethod' => $this->shipping_method,
            'shippingLabel' => $this->shipping_label,
            'payment' => $this->payment_label,
            'contact' => ['email' => $this->email, 'phone' => $this->phone],
            'address' => [
                'name' => $this->customerName(),
                'line1' => $this->address,
                'line2' => (string) $this->address_2,
                'city' => $this->city,
                'state' => $this->state,
                'postalCode' => $this->postal_code,
                'country' => $this->country,
            ],
        ];
    }
}
