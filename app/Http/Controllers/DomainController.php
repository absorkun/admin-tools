<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\StreamsCsv;
use App\Models\City;
use App\Models\District;
use App\Models\Domain;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DomainController extends Controller
{
    use StreamsCsv;

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status', 'active')->toString();
        $zone = $request->string('zone')->toString();
        $limit = (int) $request->integer('limit', 20);
        $limit = in_array($limit, [10, 20, 50, 100], true) ? $limit : 20;

        $provinceId = $request->integer('province_id') ?: null;
        $cityId = $request->integer('city_id') ?: null;
        $districtId = $request->integer('district_id') ?: null;
        $villageId = $request->integer('village_id') ?: null;

        $domains = $this->baseQuery($search, $status, $zone, $provinceId, $cityId, $districtId, $villageId)
            ->orderby('created_at')
            ->limit($limit)
            ->get();

        $provinces = Province::orderBy('name')->get(['id', 'name']);
        $cities = $provinceId ? City::where('province_id', $provinceId)->orderBy('name')->get(['id', 'name']) : collect();
        $districts = $cityId ? District::where('city_id', $cityId)->orderBy('name')->get(['id', 'name']) : collect();
        $villages = $districtId ? Village::where('district_id', $districtId)->orderBy('name')->get(['id', 'name']) : collect();

        return view('domain.index', [
            'domains' => $domains,
            'search' => $search,
            'status' => $status,
            'zone' => $zone,
            'limit' => $limit,
            'provinces' => $provinces,
            'cities' => $cities,
            'districts' => $districts,
            'villages' => $villages,
            'provinceId' => $provinceId,
            'cityId' => $cityId,
            'districtId' => $districtId,
            'villageId' => $villageId,
        ]);
    }

    public function show(int $id): View
    {
        $domain = Domain::query()
            ->with([
                'registrant:id,name,email',
                'province:id,name',
                'city:id,name',
                'district:id,name',
                'village:id,name',
            ])
            ->findOrFail($id);

        return view('domain.show', [
            'domain' => $domain,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();
        $zone = $request->string('zone')->toString();
        $provinceId = $request->integer('province_id') ?: null;
        $cityId = $request->integer('city_id') ?: null;
        $districtId = $request->integer('district_id') ?: null;
        $villageId = $request->integer('village_id') ?: null;

        $domains = $this->baseQuery($search, $status, $zone, $provinceId, $cityId, $districtId, $villageId)->orderby('created_at')->get();

        $fileName = 'domains-'.now()->format('Y-m-d-H-i-s');

        return $this->streamCsvDownload($fileName, [
            'Domain',
            'Zone',
            'Instansi',
            'Status',
            'Registered',
            'Expires',
            'Phone',
        ], $domains->map(function (Domain $domain): array {
            return [
                $domain->name,
                $domain->zone,
                $domain->nama_instansi ?? '-',
                $domain->status ?? '-',
                optional($domain->registered_at)->format('Y-m-d') ?? '-',
                optional($domain->expires_at)->format('Y-m-d') ?? '-',
                $domain->phone ?? '-',
            ];
        })->all());
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->string('q')->toString();

        $domains = Domain::query()
            ->select(['name', 'zone', 'status'])
            ->when($q !== '', function ($query) use ($q): void {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderby('created_at')
            ->limit(15)
            ->get();

        return response()->json($domains);
    }

    private function baseQuery(string $search, string $status = '', string $zone = '', ?int $provinceId = null, ?int $cityId = null, ?int $districtId = null, ?int $villageId = null)
    {
        return Domain::query()
            ->select([
                'id',
                'name',
                'zone',
                'registered_at',
                'expires_at',
                'expired_date',
                'status',
                'registrant_id',
                'domain_name_server',
                'nama_instansi',
                'phone',
                'province_id',
                'city_id',
                'district_id',
                'village_id',
            ])
            ->with(['registrant:id,name,email'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($status !== '', function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($zone !== '', function ($query) use ($zone): void {
                $query->where('zone', $zone);
            })
            ->when($provinceId !== null, function ($query) use ($provinceId): void {
                $query->where('province_id', $provinceId);
            })
            ->when($cityId !== null, function ($query) use ($cityId): void {
                $query->where('city_id', $cityId);
            })
            ->when($districtId !== null, function ($query) use ($districtId): void {
                $query->where('district_id', $districtId);
            })
            ->when($villageId !== null, function ($query) use ($villageId): void {
                $query->where('village_id', $villageId);
            });
    }
}
