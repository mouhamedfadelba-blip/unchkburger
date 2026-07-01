<?php

/*
 Lorsque qu'on utilise NomDeLaClasse:: (le Modèle), on accéde à Eloquent, l'ORM de Laravel.
Ces méthodes statiques permettent de transformer du code PHP en requêtes SQL
de manière fluide.
Voici les principales méthodes classées par action :
1. Récupération (Lecture)
all() : Récupère tous les enregistrements.
find($id) : Trouve un enregistrement par sa clé primaire.
findOrFail($id) : Idem, mais lance une erreur 404 si l'ID n'existe pas.
first() : Récupère le tout premier résultat trouvé.
get() : Exécute la requête et récupère une collection de résultats.
pluck('colonne') : Récupère uniquement les valeurs d'une colonne précise.
2. Filtrage et Tri (Le "Query Builder")
where('colonne', 'valeur') : Ajoute une clause WHERE.
whereIn('id', [1, 2, 3]) : Filtre sur une liste de valeurs.
orWhere(...) : Ajoute une condition "OU".
orderBy('colonne', 'desc') : Trie les résultats.
limit(5) / take(5) : Limite le nombre de résultats.
latest() : Trie par date de création (décroissant).
3. Création et Mise à jour
create([...]) : Crée et enregistre une instance (nécessite $fillable).
updateOrCreate([...], [...]) : Met à jour si ça existe, sinon crée.
firstOrCreate([...]) : Récupère le premier résultat correspondant, ou le crée s'il n'existe pas.
4. Agrégations (Calculs)
count() : Compte le nombre de lignes.
max('colonne') / min('colonne') : Trouve la valeur la plus haute ou basse.
avg('colonne') : Calcule la moyenne.
sum('colonne') : Additionne les valeurs d'une colonne.
5. Relations (Chargement)
with('relation') : Eager Loading (charge les relations en même temps pour éviter le problème N+1).
has('relation') : Filtre les modèles qui possèdent au moins un enfant (ex: les posts qui ont des commentaires).
whereHas('relation', callback) : Filtre les modèles selon une condition sur leur relation.
6. Suppression
destroy($id) : Supprime par ID sans charger le modèle.
truncate() : Vide complètement la table (Attention : action irréversible).
7. Pagination
paginate(15) : Découpe les résultats par pages (génère automatiquement les liens de pagination).
simplePaginate(15) : Version plus légère (uniquement "Suivant" et "Précédent").*/

namespace App\Services;

use App\Models\Order;
use App\Models\Burger;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;

class OrderService
{
    protected BurgerService $burgerService;
    protected NotificationService $notificationService;

    public function __construct(BurgerService $burgerService, NotificationService $notificationService)
    {
        $this->burgerService = $burgerService;
        $this->notificationService = $notificationService;
    }

    /**
     * @throws Throwable
     */
    public function createOrder(array $data, int $userId)
    {
        foreach ($data['items'] as $item) {
            $burger = Burger::findOrFail($item['burger_id']);
            if (!$this->burgerService->hasAvailableStock($burger, $item['quantity'])) {
                throw new Exception("Stock insuffisant pour le burger : " . $burger->nom);
            }
        }

        return DB::transaction(function () use ($data, $userId) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'en_attente',
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $burger = Burger::find($item['burger_id']);
                $unitPrice = $burger->unit_price;
                $subtotal = $unitPrice * $item['quantity'];

                $order->burgers()->attach($burger->id, [
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice
                ]);

                $burger->decrement('stock', $item['quantity']);

                $total += $subtotal;
            }


            $order->update(['total_amount' => $total]);

            $this->notificationService->sendOrderConfirmation($order);
            $this->notificationService->notifyAdmin($order);

            return $order;
        });
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function updateStatus(Order $order, string $newStatus): void
    {
        $oldStatus = $order->status;

        if ($newStatus === 'annulee') {
            if ($oldStatus !== 'en_attente') {
                throw new Exception("Désolé, cette commande ne peut plus être annulée car elle est déjà " . $oldStatus);
            }

            foreach ($order->burgers as $burger) {
                $burger->increment('stock', $burger->pivot->quantity);
            }

            $this->notificationService->sendCancellationNotice($order);
        }

        if ($newStatus === 'prete' && $oldStatus !== 'prete') {
            $this->notificationService->sendInvoice($order);
        }

        $order->update(['status' => $newStatus]);

    }

    public function getPaginatedOrders(array $filters): LengthAwarePaginator
    {
        return Order::with(['user', 'burgers'])
            ->latest()
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('numero_commande', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->paginate(15);
    }
}
