<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedmineUsers extends Model
{
    use HasFactory;

    protected $table = 'own_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'surname',
        'redmine_id'
    ];
}
