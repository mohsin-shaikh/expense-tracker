<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

trait HasActivity
{
    /**
     * The "booted" method of the trait.
     *
     * @return void
     */
    public static function bootHasActivity(): void
    {
        static::created(function($model) {
            $model->activity()->create([
                'user_id' => Auth::id(),
            ]);
        });

        static::deleting(function($model) {
            $model->activity->delete();
        });
    }

    /**
     * Get the model's activity.
     *
     * @return MorphOne
     */
    public function activity(): MorphOne
    {
        return $this->morphOne(Activity::class, 'subject');
    }
}
