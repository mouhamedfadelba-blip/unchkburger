<?php

namespace App\Models;

use Database\Factories\BurgerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Burger extends Model
{
    /** @use HasFactory<BurgerFactory> */
    use HasFactory;

    /*Pour pouvoir faire create, update ou delete directement sur le modele
    et eviter l'erreur Illuminate\Database\Eloquent\MassAssignmentException*/
    protected $fillable = ['nom', 'unit_price', 'description', 'image', 'stock', 'category_id', 'is_archived'];

    public function category(): BelongsTo
    {
        /* belongsTo (relation un a un)
        un burger est associer a un seul category*/
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        /*belongsToMany (relation un a plusieur)
        un burger peut se trouver dans plusieur commande*/
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'unit_price');
    }
}
