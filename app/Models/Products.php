<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
	
	protected $table = 'products';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
		'product_name',
		'slug',
		'sku',
		'price',
        'discounted_price',
		'quantity',
		'description',
		'video',
		'keywords',
		'seo_title',
        'seo_keywords',
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
        'category_id',
		'product_name',
		'slug',
		'sku',
		'price',
        'discounted_price',
		'quantity',
		'description',
		'video',
		'keywords',
		'seo_title',
        'seo_keywords',
		'seo_description',
		'robot_tags',
		'status'
    ];
	
}
