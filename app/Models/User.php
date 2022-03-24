<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $address
 * @property string $phone
 * @property string $password
 *
 * @property Collection|Book[] $books
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
	protected $table = 'users';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'surname',
		'patronymic',
		'address',
		'phone',
		'password'
	];

	public function books()
	{
		return $this->belongsToMany(Book::class, 'user_book')
					->withPivot('id')
					->withTimestamps();
	}
}
