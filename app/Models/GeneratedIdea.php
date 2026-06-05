<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\GeneratedIdeaFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property int $user_id
 * @property string $startup_name
 * @property string $summary
 * @property string $investor_pitch
 * @property string $model
 * @property bool $public
 * @property-read Collection<int, GeneratedIdeaPriceTier> $priceTiers
 * @property-read int|null $price_tiers_count
 * @property-read Collection<int, GeneratedIdeaTestimonial> $testimonials
 * @property-read int|null $testimonials_count
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereInvestorPitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereStartupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdea whereUserId($value)
 *
 * @mixin \Eloquent
 */
class GeneratedIdea extends Model
{
    /** @use HasFactory<GeneratedIdeaFactory> */
    use HasFactory;

    public $guarded = [];

    public $with = ['priceTiers', 'testimonials'];

    public $casts = [
        'public' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function priceTiers(): HasMany
    {
        return $this->hasMany( GeneratedIdeaPriceTier::class );
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany( GeneratedIdeaTestimonial::class );
    }
}
