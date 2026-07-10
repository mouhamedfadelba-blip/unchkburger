<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\StatService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected StatService $statService;

    public function __construct(StatService $statService)
    {
        $this->statService = $statService;
    }

    public function index()
    {
        $userId = Auth::id();

        $latestOrder = $this->statService->getLatestOrderForUser($userId);
        $featuredBurgers = $this->statService->getFeaturedBurgers(4);
        $totalSpent = $this->statService->getTotalSpentByUser($userId);
        $burgersCount = $this->statService->getBurgersEatenCount($userId);

        return view('customer.dashboard', compact(
            'latestOrder',
            'featuredBurgers',
            'totalSpent',
            'burgersCount'
        ));
    }
}
