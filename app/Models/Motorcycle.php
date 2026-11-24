<?php

namespace App\Models;

use Database\Factories\MotorcycleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Motorcycle extends Model
{
    /** @use HasFactory<MotorcycleFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Columns safe to select when rendering public Guest pages (BR-06).
     *
     * @var list<string>
     */
    public const PUBLIC_COLUMNS = [
        'id',
        'code',
        'brand_id',
        'model',
        'slug',
        'category',
        'year',
        'color',
        'engine_cc',
        'transmission',
        'mileage',
        'plate_region',
        'setting_condition',
        'modification_notes',
        'engine_ever_opened',
        'engine_notes',
        'has_bpkb',
        'has_stnk',
        'has_faktur',
        'tax_expired_at',
        'warranty',
        'description',
        'selling_price',
        'is_negotiable',
        'status',
        'is_featured',
        'views',
        'created_at',
        'updated_at',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'brand_id',
        'model',
        'slug',
        'category',
        'year',
        'color',
        'engine_cc',
        'transmission',
        'mileage',
        'plate_region',
        'setting_condition',
        'modification_notes',
        'engine_ever_opened',
        'engine_notes',
        'has_bpkb',
        'has_stnk',
        'has_faktur',
        'tax_expired_at',
        'warranty',
        'description',
        'purchase_price',
        'purchase_date',
        'purchase_source',
        'selling_price',
        'is_negotiable',
        'status',
        'is_featured',
        'views',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'engine_cc' => 'integer',
            'mileage' => 'integer',
            'engine_ever_opened' => 'boolean',
            'has_bpkb' => 'boolean',
            'has_stnk' => 'boolean',
            'has_faktur' => 'boolean',
            'tax_expired_at' => 'date',
            'purchase_price' => 'integer',
            'purchase_date' => 'date',
            'selling_price' => 'integer',
            'is_negotiable' => 'boolean',
            'is_featured' => 'boolean',
            'views' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Motorcycle $motorcycle): void {
            if (blank($motorcycle->code)) {
                $motorcycle->code = self::generateNextCode();
            }

            if (blank($motorcycle->slug)) {
                $brandName = $motorcycle->brand?->name
                    ?? Brand::query()->whereKey($motorcycle->brand_id)->value('name')
                    ?? 'motor';

                $motorcycle->slug = Str::slug("{$brandName} {$motorcycle->model} {$motorcycle->year} {$motorcycle->code}");
            }
        });
    }

    public static function generateNextCode(): string
    {
        $lastCode = self::withTrashed()
            ->where('code', 'like', 'MTR-%')
            ->orderByDesc('id')
            ->value('code');

        $nextNumber = 1;

        if (is_string($lastCode) && preg_match('/MTR-(\d+)/', $lastCode, $matches)) {
            $nextNumber = ((int) $matches[1]) + 1;
        }

        return sprintf('MTR-%04d', $nextNumber);
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasMany<MotorcyclePhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(MotorcyclePhoto::class)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * @return HasOne<MotorcyclePhoto, $this>
     */
    public function primaryPhoto(): HasOne
    {
        return $this->hasOne(MotorcyclePhoto::class)
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * @return HasMany<ReconditioningCost, $this>
     */
    public function reconditioningCosts(): HasMany
    {
        return $this->hasMany(ReconditioningCost::class);
    }

    /**
     * @return HasOne<Sale, $this>
     */
    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    /**
     * Scope to units visible in public catalog (Tersedia & Dipesan).
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublicVisible(Builder $query): Builder
    {
        return $query->whereIn('status', ['available', 'booked']);
    }

    /**
     * Scope selecting only columns safe for Guest views (BR-06).
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublicSelect(Builder $query): Builder
    {
        return $query->select(self::PUBLIC_COLUMNS);
    }

    /**
     * Scope filtering catalog queries by keyword, brand, category, year, price, and transmission.
     *
     * @param  Builder<self>  $query
     * @param  array<string, mixed>  $filters
     * @return Builder<self>
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (! empty($filters['q'])) {
            $keyword = trim((string) $filters['q']);
            $query->where(function (Builder $sub) use ($keyword): void {
                $sub->where('model', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%")
                    ->orWhere('color', 'like', "%{$keyword}%")
                    ->orWhereHas('brand', function (Builder $brandQuery) use ($keyword): void {
                        $brandQuery->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        if (! empty($filters['brand'])) {
            $brand = (string) $filters['brand'];
            $query->whereHas('brand', function (Builder $brandQuery) use ($brand): void {
                $brandQuery->where('slug', $brand)->orWhere('id', $brand);
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category', (string) $filters['category']);
        }

        if (! empty($filters['transmission'])) {
            $query->where('transmission', (string) $filters['transmission']);
        }

        if (! empty($filters['min_price']) && is_numeric($filters['min_price'])) {
            $query->where('selling_price', '>=', (int) $filters['min_price']);
        }

        if (! empty($filters['max_price']) && is_numeric($filters['max_price'])) {
            $query->where('selling_price', '<=', (int) $filters['max_price']);
        }

        if (! empty($filters['min_year']) && is_numeric($filters['min_year'])) {
            $query->where('year', '>=', (int) $filters['min_year']);
        }

        if (! empty($filters['max_year']) && is_numeric($filters['max_year'])) {
            $query->where('year', '<=', (int) $filters['max_year']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', (string) $filters['status']);
        }

        return $query;
    }

    public function fullName(): string
    {
        $brandName = $this->brand?->name ?? '';

        return trim("{$brandName} {$this->model}");
    }

    public function formattedSellingPrice(): string
    {
        return 'Rp '.number_format((int) $this->selling_price, 0, ',', '.');
    }

    public function formattedPurchasePrice(): string
    {
        return 'Rp '.number_format((int) $this->purchase_price, 0, ',', '.');
    }

    public function formattedMileage(): string
    {
        return number_format((int) $this->mileage, 0, ',', '.').' km';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'booked' => 'Dipesan',
            'sold' => 'Terjual',
            default => ucfirst((string) $this->status),
        };
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'matic' => 'Matic',
            'bebek' => 'Bebek',
            'sport' => 'Sport',
            'trail' => 'Trail',
            default => 'Lainnya',
        };
    }

    public function transmissionLabel(): string
    {
        return match ($this->transmission) {
            'matic' => 'Matic',
            'manual' => 'Manual',
            'kopling' => 'Kopling',
            default => ucfirst((string) $this->transmission),
        };
    }

    public function settingConditionLabel(): string
    {
        return match ($this->setting_condition) {
            'standar' => 'Standar Pabrik',
            'modifikasi_ringan' => 'Modifikasi Ringan',
            'modifikasi_berat' => 'Modifikasi Berat',
            default => 'Standar Pabrik',
        };
    }

    public function isTaxActive(): ?bool
    {
        if ($this->tax_expired_at === null) {
            return null;
        }

        return $this->tax_expired_at->endOfDay()->gte(Carbon::today());
    }

    public function taxLabel(): string
    {
        if ($this->tax_expired_at === null) {
            return 'Belum dicatat';
        }

        if ($this->isTaxActive()) {
            return 'Hidup s.d. '.$this->tax_expired_at->locale('id')->translatedFormat('d F Y');
        }

        return 'Pajak Mati (berakhir '.$this->tax_expired_at->locale('id')->translatedFormat('d M Y').')';
    }

    public function primaryPhotoUrl(): ?string
    {
        $photo = $this->relationLoaded('primaryPhoto')
            ? $this->primaryPhoto
            : ($this->relationLoaded('photos') ? $this->photos->first() : $this->primaryPhoto()->first());

        return $photo?->url();
    }

    public function whatsappUrl(?string $whatsappNumber = null): string
    {
        $phone = preg_replace('/\D+/', '', $whatsappNumber ?? Setting::getValue('whatsapp_number', '6281234567890'));
        $storeName = Setting::getValue('store_name', 'Andara Motor');
        $message = sprintf(
            'Halo %s, saya tertarik dengan %s %d (Kode: %s). Apakah masih tersedia?',
            $storeName,
            $this->fullName(),
            $this->year,
            $this->code
        );

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }
}