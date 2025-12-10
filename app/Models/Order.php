<?php
// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id','number','subtotal','coupon_discount','total','coupon_code',
        'currency','status','paid_at','meta','deliverity'
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'total'           => 'decimal:2',
        'paid_at'         => 'datetime',
        'meta'            => 'array',
    ];

    // --- روابط ---
    public function user()     { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    // --- اسکوپ‌ها ---
    public function scopePending($q)   { return $q->where('status','pending'); }
    public function scopePaid($q)      { return $q->where('status','paid'); }
    public function scopeCompleted($q) { return $q->where('status','completed'); }

    // --- متدها/اکشن‌ها ---
    public static function generateNumber(): string
    {
        return 'ORD-'.Str::upper(Str::random(10));
    }

    public function recalcTotalsFromItems(): void
    {
        $sub = $this->items->sum(fn($i) => $i->qty * $i->unit_price);
        $this->subtotal = $sub;
        // اگر کوپن داری، مقدار coupon_discount را قبلاً ست کن یا اینجا از سشن/متا بخوان
        $this->total = max($this->subtotal - $this->coupon_discount, 0);
        $this->save();
    }

    public function applyCoupon(?string $code, float $discount): void
    {
        $this->coupon_code     = $code ?: null;
        $this->coupon_discount = max($discount, 0);
        $this->total           = max($this->subtotal - $this->coupon_discount, 0);
        $this->save();
    }

    public function markPaid(): void
    {
        $this->status  = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    public function canPay(): bool
    {
        return in_array($this->status, ['pending'], true) && $this->total > 0;
    }
}
