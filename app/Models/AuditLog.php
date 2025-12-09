<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'action',
        'model',
        'model_id',
        'changes',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return ['changes' => 'json'];
    }

    // Relation

    /**
     * Relation one-to-many, User model.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
