<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $generated_idea_id
 * @property string $name
 * @property int $price_cents
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereGeneratedIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier wherePriceCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaPriceTier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GeneratedIdeaPriceTier extends Model
{
    public $guarded = [];
}
