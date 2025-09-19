<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterNavigations extends Model
{
    use HasFactory;
	
	protected $table = 'footer_navigations';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'target_window',
		'menu_type',
		'menu_page_id',
        'slug',
		'url',
		'title',
        'seo_title',
		'seo_keyword',
		'seo_description',
        'robot_tags',
		'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
	
    ];
	
}