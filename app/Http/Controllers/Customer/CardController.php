<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CardController extends Controller
{
    /**
     * @throws CircularDependencyException
     * @throws EntryNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function add(Burger $burger)
    {
        $card = session()->get('card', []);

        if (isset($card[$burger->id])) {
            $card[$burger->id]['quantity']++;
        } else {
            $card[$burger->id] = [
                "nom" => $burger->nom,
                "quantity" => 1,
                "amount" => $burger->unit_price,
                "id" => $burger->id
            ];
        }

        session()->put('card', $card);

        return redirect()->back()->with('success', $burger->nom . ' a ete ajoute a votre panier !');
    }
    /**
     * @throws CircularDependencyException
     * @throws NotFoundExceptionInterface
     * @throws EntryNotFoundException
     * @throws ContainerExceptionInterface
     */
    public function index()
    {
        $card = session()->get('card', []);
        $total = array_reduce($card, function($carry, $item) {
            return $carry + ($item['amount'] * $item['quantity']);
        }, 0);

        return view('customer.cards.index', compact('card', 'total'));
    }
    /**
     * @throws CircularDependencyException
     * @throws NotFoundExceptionInterface
     * @throws EntryNotFoundException
     * @throws ContainerExceptionInterface
     */
    public function remove($id)
    {
        $card = session()->get('card', []);

        if(isset($card[$id])) {
            unset($card[$id]);
            session()->put('card', $card);
        }

        return redirect()->back()->with('success', 'Burger retire du panier.');
    }
    public function clear()
    {
        session()->forget('card');
        return redirect()->route('customer.catalogues.index')->with('success', 'Le panier a ete vide.');
    }
}
