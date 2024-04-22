<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ban extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function ban(string|array $ips, array $metas = []): void
    {
        foreach ((array) $ips as $ip) {
            Ban::create([
                'ip' => $ip,
                'metas' => count($metas) ? $metas : null,
            ]);
        }
    }
}
