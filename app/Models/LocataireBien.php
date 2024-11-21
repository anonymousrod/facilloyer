<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LocataireBien
 * 
 * @property int $id
 * @property int $locataire_id
 * @property int $bien_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Bien $bien
 * @property Locataire $locataire
 *
 * @package App\Models
 */
class LocataireBien extends Model
{
	protected $table = 'locataire_bien';

	protected $casts = [
		'locataire_id' => 'int',
		'bien_id' => 'int'
	];

	protected $fillable = [
		'locataire_id',
		'bien_id'
	];

	public function bien()
	{
		return $this->belongsTo(Bien::class);
	}

	public function locataire()
	{
		return $this->belongsTo(Locataire::class);
	}
}
