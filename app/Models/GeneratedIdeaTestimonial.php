<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $generated_idea_id
 * @property string $comment
 * @property string|null $author
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereGeneratedIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GeneratedIdeaTestimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GeneratedIdeaTestimonial extends Model
{
    public $guarded = [];
}
