<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'selected_branch_id',
        'lat',
        'lng',
        'state',
        'city',
        'sms_consent',
    ];

    protected $casts = [
        'sms_consent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}