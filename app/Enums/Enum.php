<?php

declare(strict_types=1);

namespace App\Enums;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Enum
{
    /**
     * Get all items
     *
     * @return Collection
     */
    public static function all(): Collection
    {
        return static::prepare(
            static::getConstants()
        );
    }

    /**
     * Get valueso nly
     *
     * @return Collection
     */
    public static function values(): Collection
    {
        return static::getConstants()->values();
    }

    /**
     * Get keys only
     *
     * @return Collection
     */
    public static function keys(): Collection
    {
        return static::getConstants()->keys();
    }

    /**
     * Get key-value array
     *
     * @return array
     */
    public static function keyValueArray(): array
    {
        $items = self::all();
        $data  = [];
        foreach ($items as $item) {
            $data[$item['id']] = $item['name'];
        }

        return $data;
    }

    /**
     * @param $id
     *
     * @return ?array
     */
    public static function getById($id): ?array
    {
        if (!$id) {
            return null;
        }

        $constant = static::getConstants()->search($id, true);

        if (!$constant) {
            return null;
        }

        return static::prepare(collect([$constant => $id]))->first();
    }

    /**
     * Get list of items by ID
     *
     * @param array $list List of IDs
     *
     * @return array
     */
    public static function listById(array $ids): array
    {
        $response = [];
        foreach ($ids as $id) {
            $response[] = self::getById($id);
        }

        return $response;
    }

    /**
     * Prepare the response
     *
     * @param Collection $constants Constrants
     *
     * @return Collection
     */
    protected static function prepare(Collection $constants): Collection
    {
        $data = [];
        foreach ($constants as $constant => $value) {
            $data[] = [
                'id'   => $value,
                'name' => static::getTranslatedName($constant)
            ];
        }

        return collect($data);
    }

    /**
     * Get translated name by a constant
     *
     * @param string $constant Constant
     *
     * @return string
     */
    protected static function getTranslatedName(string $constant): string
    {
        return __('enum.' . Str::snake(static::getClassName()) . '.' . Str::lower($constant));
    }

    /**
     * Get all constants
     *
     * @return Collection
     */
    protected static function getConstants(): Collection
    {
        return collect((new ReflectionClass(static::class))->getConstants());
    }

    /**
     * Get a class name
     *
     * @return string
     */
    protected static function getClassName(): string
    {
        return (new ReflectionClass(static::class))->getShortName();
    }
}
