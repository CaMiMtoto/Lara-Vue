<?php

namespace App\Http\Controllers;

use App\Models\PerformanceContract;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerformanceContractController extends Controller
{
    public function index()
    {
        $search = \request('search');
        $perPage = request()->input('per_page', 10); // Default to 10

        $contracts = PerformanceContract::query()
            ->with(['createdBy'])
            // ->where('created_by', '=', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate($perPage)
            ->withQueryString();
        return Inertia::render(
            'PerformanceMatrix/Index', [
            'contracts' => $contracts,
            'filters' => [
                'search' => $search,
                'per_page' => $perPage,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'start_year' => ['required', 'integer', 'digits:4'],
            'end_year' => ['required', 'integer', 'digits:4'],
        ]);

        $data['created_by'] = auth()->id();

        PerformanceContract::create($data);
        return back()->with('success', 'Contract created successfully');
    }

    public function update(Request $request, PerformanceContract $contract)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'start_year' => ['required', 'integer', 'digits:4'],
            'end_year' => ['required', 'integer', 'digits:4'],
        ]);
        $contract->update($data);
        return back()->with('success', 'Contract updated successfully');
    }

    public function destroy(PerformanceContract $contract)
    {
        try {
            throw new \Exception('test');
            $contract->delete();
        } catch (\Exception $e) {
            info($e->getMessage());
            return back()->with('error', 'Error deleting contract');
        }
        return back()->with('success', 'Contract deleted successfully');
    }
}
