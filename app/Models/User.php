<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['artwork_url_lg'];

    protected $hiddens = ['media'];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('artwork')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg']);
        $this->addMediaConversion('sm')
            ->width(60)
            ->height(60)
            ->performOnCollections('artwork')->nonOptimized()->nonQueued();

        $this->addMediaConversion('md')
            ->width(120)
            ->height(120)
            ->performOnCollections('artwork')->nonOptimized()->nonQueued();

        $this->addMediaConversion('lg')
            ->width(300)
            ->height(300)
            ->performOnCollections('artwork')->nonOptimized()->nonQueued();
    }


    public function getArtworkUrlLgAttribute($value)
    {
        $media = $this->getFirstMedia('artwork');
        if (!$media) {
            if (isset($this->log) && isset($this->log->artwork_url)) {
                return $this->log->artwork_url;
            } else {
                return asset('common/default/profile.png');
            }
        } else {
            if ($media->disk != 'public') {
                return $media->getTemporaryUrl(Carbon::now()->addMinutes(intval(1140)), 'md');
            } else {
                return $media->getFullUrl('md');
            }
        }
    }
}
