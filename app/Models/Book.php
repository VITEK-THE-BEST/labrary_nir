<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * 
 * @property int $id
 * @property string $name
 * @property string $author
 * @property string $genre
 * @property string $price
 * @property string $reserved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Book extends Model
{
	protected $table = 'books';

	protected $fillable = [
		'name',
		'author',
		'genre',
		'price',
		'reserved'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_book')
					->withPivot('id')
					->withTimestamps();
	}
}
