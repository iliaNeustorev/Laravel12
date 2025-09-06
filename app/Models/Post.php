<?php

namespace App\Models;

use App\Enums\Posts\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'url',
        'content',
        'title',
        'category_id',
        'status'
    ];

    protected $casts = [
        'status' => Status::class,
        'created_at' => 'date_format:d.m.Y'
    ];

    /**
     *
     * @return string
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }

    /**
     *
     * @return string
     */
    public function getUpdatedAtFormattedAttribute(): string
    {
        return $this->updated_at->format('d.m.Y H:i:s');
    }

    /**
     *
     * @return boolean
     */
    public function getIsDraftAttribute(): bool
    {
        return $this->status === Status::DRAFT;
    }
    /**
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     *
     * @param [type] $query
     * @param array $filters
     * @return [type] $query
     */
    public function scopeFilter($query, array $filters = [])
    {
        return $query
            ->when(isset($filters['status']), fn($query) => $query->where('status', $filters['status']))
            ->when(isset($filters['date']), fn($query) => $query->whereDate('created_at', '>=', $filters['date']))
            ->when(isset($filters['category']), fn($query) => $query->where('category_id', $filters['category']));
    }
}
