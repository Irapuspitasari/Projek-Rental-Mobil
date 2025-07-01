<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'name',
        'address',
        'city',
        'zip',
        'start_date',
        'end_date',
        'duration_days',
        'user_id',
        'item_id',
        'region',
        'driver_option',
        'status',
        'base_price',
        'driver_fee',
        'out_of_region_fee',
        'overtime_fee',
        'total_price',
        'notes',
        'actual_end_date',
        'is_overtime',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'base_price' => 'decimal:2',
        'driver_fee' => 'decimal:2',
        'out_of_region_fee' => 'decimal:2',
        'overtime_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
        'actual_end_date' => 'datetime',
        'is_overtime' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function overtime()
    {
        return $this->hasOne(Overtime::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Accessors & Mutators
    protected function formattedTotalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Rp ' . number_format($this->total_price, 0, ',', '.'),
        );
    }

    protected function rentalPeriod(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y'),
        );
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeWithOvertime($query)
    {
        return $query->where('is_overtime', true);
    }

    // Business Logic Methods
    public function calculateOvertime()
    {
        if (!$this->end_date || !$this->actual_end_date) {
            return null;
        }

        // Hitung selisih waktu antara actual end date dan end date yang dijadwalkan
        $overtimeHours = $this->actual_end_date->diffInHours($this->end_date);

        // Jika actual end date lebih awal dari end date, tidak ada overtime
        if ($this->actual_end_date <= $this->end_date) {
            return null;
        }

        $feePerHour = 20000; // Rp 20.000/jam
        $totalFee = $overtimeHours * $feePerHour;

        return [
            'hours' => $overtimeHours,
            'fee_per_hour' => $feePerHour,
            'total_fee' => $totalFee
        ];
    }

    public function markAsCompleted($actualEndDate = null)
    {
        $this->actual_end_date = $actualEndDate ?? now();

        $overtimeData = $this->calculateOvertime();

        if ($overtimeData) {
            $this->overtime()->create([
                'hours' => $overtimeData['hours'],
                'fee_per_hour' => $overtimeData['fee_per_hour'],
                'total_fee' => $overtimeData['total_fee'],
                'description' => 'Terlambat pengembalian'
            ]);

            $this->update([
                'overtime_fee' => $overtimeData['total_fee'],
                'total_price' => $this->total_price + $overtimeData['total_fee'],
                'is_overtime' => true,
                'status' => 'Completed'
            ]);
        } else {
            $this->update([
                'status' => 'Completed',
                'is_overtime' => false
            ]);
        }

        return $this;
    }
    public function getIsPaidAttribute()
    {
        return $this->payment && $this->payment->status === 'Paid';
    }
    public function markAsOnRent()
    {
        if ($this->status === 'Confirmed' && $this->is_paid) {
            $this->update(['status' => 'On Rent']);
            return true;
        }

        return false; // Failed to update status
    }
    protected static function booted()
    {
        static::saved(function ($booking) {
            $booking->updateItemAvailability();
        });

        static::deleted(function ($booking) {
            $booking->item->updateAvailability();
        });
    }

    public function updateItemAvailability()
    {
        $item = $this->item;

        if (in_array($this->status, ['Confirmed', 'On Rent'])) {
            $item->available = false;
            $item->save();
        } else {
            $hasActiveBooking = $item->bookings()
                ->whereIn('status', ['Confirmed', 'On Rent'])
                ->where('id', '!=', $this->id)
                ->exists();

            $item->available = !$hasActiveBooking;
            $item->save();
        }
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function canBeReviewed(): bool
    {
        return $this->status === 'Completed' && !$this->review()->exists();
    }
}
