<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Relationships
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('name', 'Pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('name', 'Processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('name', 'Shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('name', 'Delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('name', 'Cancelled');
    }

    /**
     * Static methods to get status IDs
     */
    public static function getPendingId()
    {
        return self::where('name', 'Pending')->first()->id;
    }

    public static function getProcessingId()
    {
        return self::where('name', 'Processing')->first()->id;
    }

    public static function getShippedId()
    {
        return self::where('name', 'Shipped')->first()->id;
    }

    public static function getDeliveredId()
    {
        return self::where('name', 'Delivered')->first()->id;
    }

    public static function getCancelledId()
    {
        return self::where('name', 'Cancelled')->first()->id;
    }

    /**
     * Check if status allows cancellation
     */
    public function canBeCancelled()
    {
        return in_array($this->name, ['Pending', 'Processing']);
    }

    /**
     * Check if status is final (cannot be changed)
     */
    public function isFinal()
    {
        return in_array($this->name, ['Delivered', 'Cancelled']);
    }

    /**
     * Get next possible statuses
     */
    public function getNextStatuses()
    {
        $transitions = [
            'Pending' => ['Processing', 'Cancelled'],
            'Processing' => ['Shipped', 'Cancelled'],
            'Shipped' => ['Delivered'],
            'Delivered' => [],
            'Cancelled' => []
        ];

        $nextStatusNames = $transitions[$this->name] ?? [];
        
        return self::whereIn('name', $nextStatusNames)->get();
    }

    /**
     * Get color for status badge (useful for frontend)
     */
    public function getColorAttribute()
    {
        $colors = [
            'Pending' => 'yellow',
            'Processing' => 'blue',
            'Shipped' => 'purple',
            'Delivered' => 'green',
            'Cancelled' => 'red'
        ];

        return $colors[$this->name] ?? 'gray';
    }

    /**
     * Get icon for status (useful for frontend)
     */
    public function getIconAttribute()
    {
        $icons = [
            'Pending' => 'clock',
            'Processing' => 'cog',
            'Shipped' => 'truck',
            'Delivered' => 'check-circle',
            'Cancelled' => 'x-circle'
        ];

        return $icons[$this->name] ?? 'circle';
    }
}