<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeaturedDomainController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->string('tab', 'expired')->toString();
        $search = $request->string('search')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $expiredDomains = Domain::query()
            ->select(['id', 'name', 'zone', 'status', 'expires_at', 'expired_date', 'registrant_id', 'nama_instansi', 'phone'])
            ->with(['registrant:id,name,email'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('expires_at', 'asc')
            ->limit($limit)
            ->get();

        $inactiveDomains = Domain::query()
            ->select(['id', 'name', 'zone', 'status', 'expires_at', 'expired_date', 'registrant_id', 'nama_instansi', 'phone'])
            ->with(['registrant:id,name,email'])
            ->where('status', '!=', 'active')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return view('featured-domain.index', [
            'tab' => $tab,
            'search' => $search,
            'limit' => $limit,
            'expiredDomains' => $expiredDomains,
            'inactiveDomains' => $inactiveDomains,
        ]);
    }
}
