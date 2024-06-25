<?php

namespace App\Helpers;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function checkPermission(
        string|array $permissionKey,
        string $permissionType
    ): string|null|array {

        if (is_string($permissionKey)) {
            $return = null;
        }

        if (is_array($permissionKey)) {
            $return = [];

            foreach ($permissionKey as $key) {
                $return[$key] = null;
            }
        }

        $loggedInUser = Auth::user();

        $position = Position::whereHas(
            'modelPosition',
            function ($q) use ($loggedInUser) {
                $q->where('model_id', $loggedInUser->id);
            }
        )
            ->first();

        if (! $position) {
            return $return;
        }

        $permissions = $position
            ->permissions()
            ->where('type', $permissionType)
            ->when(
                is_array($permissionKey),
                function ($q) use ($permissionKey) {
                    $q->whereIn('key', $permissionKey);
                }
            )
            ->when(
                is_string($permissionKey),
                function ($q) use ($permissionKey) {
                    $q->where('key', $permissionKey);
                }
            )
            ->get();

        if (is_string($permissionKey)) {
            return $permissions->count() ? $position->key : null;
        }

        foreach ($permissionKey as $key) {
            $return[$key] = $permissions->where('key', $key)->count()
                ? $position->key
                : null;
        }

        return $return;
    }
}
