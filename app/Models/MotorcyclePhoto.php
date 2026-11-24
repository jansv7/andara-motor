<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MotorcyclePhoto extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'motorcycle_id',
        'path',
        'is_primary',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Motorcycle, $this>
     */
    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function url(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://', '/'])) {
            return $this->path;
        }

        if (Str::startsWith($this->path, 'images/')) {
            return asset($this->path);
        }

        return Storage::disk('public')->url($this->path);
    }
}