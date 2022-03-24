<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBook
 * 
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Book $book
 * @property User $user
 *
 * @package App\Models
 */
class UserBook extends Model
{
	protected $table = 'user_book';

	protected $casts = [
		'user_id' => 'int',
		'book_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'book_id'
	];

	public function book()
	{
		return $this->belongsTo(Book::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
