<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/** The shop pages' product grids: which products each page lists, in what order. */
class CollectionController extends Controller
{
    public function index()
    {
        return view('admin.collections.index', ['collections' => Collection::withCount('products')->orderBy('name')->get()]);
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', ['collection' => $collection, 'products' => $collection->products()->get()]);
    }

    /** The grid is edited as product codes, one per line, top to bottom. */
    public function update(Request $request, Collection $collection)
    {
        $data = $request->validate(['name' => 'required|string|max:120', 'codes' => 'nullable|string']);
        $codes = collect(preg_split('/[\s,]+/', (string) $data['codes']))->filter()->unique()->values();
        $ids = Product::whereIn('code', $codes)->pluck('id', 'code');

        $unknown = $codes->reject(fn ($code) => isset($ids[$code]));
        if ($unknown->isNotEmpty()) {
            throw ValidationException::withMessages(['codes' => 'Unknown product codes: '.$unknown->implode(', ')]);
        }

        $collection->update(['name' => $data['name']]);
        $collection->products()->sync($codes->mapWithKeys(fn ($code, $i) => [$ids[$code] => ['position' => $i]])->all());

        return back()->with('status', "{$collection->name} saved ({$codes->count()} products).");
    }
}
