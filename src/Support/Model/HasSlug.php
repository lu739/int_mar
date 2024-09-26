<?php

namespace Support\Model;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            self::makeSlug($model);
        });
    }

    protected static function makeSlug(Model $model): void
    {
        $slug = self::slugUniqie(str($model->{self::slugFrom()})
            ->slug()
            ->value());

        $model->{self::slugColumn()} = $model->{self::slugColumn()}  ?? $slug;;
    }

    protected static function slugUniqie(string $slug): string
    {
        $originSlug = $slug;
        $i = 0;

        while (self::query()->where(self::slugColumn(), $slug)->exists()) {
            $slug = $originSlug . '-' . ++$i;
        }
        return $slug;
    }

    protected static function slugColumn(): string
    {
        return 'slug';
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }
}
