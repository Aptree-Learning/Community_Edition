<?php

namespace App\Models;

use Storage;
use App\Enums\ModuleItemType;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleItem extends Model implements Sortable
{
    use SortableTrait;
    use HasFactory;

    protected $casts = [
        'type' => ModuleItemType::class,
        'video_response' => 'array'
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $guarded = [];

    protected $appends = [ 'image_url', 'author', ]; 

    public function getImage()
    {
        if (isUrl($this->image))
            return $this->image;
        else if($this->image){
            return Storage::disk('do')->url($this->image);
        }
        return '';
    }

    public function getImageUrlAttribute()
    {
        return $this->getImage();
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_module_activity')->withPivot('completed_at');
    }

    public function getAuthorAttribute()
    {
        $user = User::where("id", $this->user_id)->first();
        if($user)
        {
            return $user->email;
        }
        else {
            return '';
        }
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
