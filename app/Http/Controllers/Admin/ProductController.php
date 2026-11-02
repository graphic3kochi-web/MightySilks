<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::withCount('collections')
            ->when($request->q, fn ($q, $term) => $q->where(fn ($q) => $q
                ->where('title', 'like', "%$term%")->orWhere('code', 'like', "%$term%")->orWhere('sku', 'like', "%$term%")))
            ->when($request->category, fn ($q, $category) => $q->where('category', $category))
            ->when($request->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'hidden', fn ($q) => $q->where('is_active', false))
            ->when($request->stock === 'low', fn ($q) => $q->where('stock', '<=', 3))
            ->orderBy('position')->orderByDesc('id')
            ->paginate(20)->withQueryString();

        return view('admin.products.index', ['products' => $products, 'total' => Product::count()]);
    }

    public function create()
    {
        return $this->form(new Product(['stock' => 10, 'is_active' => true, 'blouse' => 'yes', 'category' => 'saree', 'gallery' => [], 'card_layers' => []]));
    }

    public function edit(Product $product)
    {
        return $this->form($product);
    }

    public function store(Request $request)
    {
        $product = new Product(['position' => (int) Product::max('position') + 1]);
        $this->save($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product added.');
    }

    public function update(Request $request, Product $product)
    {
        $this->save($request, $product);

        return back()->with('status', 'Product saved.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', "“{$product->title}” deleted.");
    }

    private function form(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'collections' => Collection::orderBy('name')->get(),
            'selected' => $product->exists ? $product->collections()->pluck('collections.id')->all() : [],
        ]);
    }

    /**
     * Saves the fields and photos. Photos are uploaded to storage/app/public/products; the shop card
     * shows the card photo (a new upload replaces the design's layered crop) and the hover photo.
     */
    private function save(Request $request, Product $product): void
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'page_title' => 'nullable|string|max:255',
            'code' => ['nullable', 'regex:/^[a-z0-9-]+$/', 'max:40', Rule::unique('products', 'code')->ignore($product->id)],
            'price' => 'required|numeric|min:0|max:9999999',
            'sku' => 'nullable|string|max:60',
            'stock' => 'required|integer|min:0|max:100000',
            'category' => ['required', Rule::in(array_keys(Product::CATEGORIES))],
            'color' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'fabric' => 'nullable|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'blouse' => 'required|in:yes,no',
            'product_details' => 'nullable|string|max:2000',
            'design_details' => 'nullable|string|max:2000',
            'material_care' => 'nullable|string|max:2000',
            'alt' => 'nullable|string|max:255',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
            'collections' => 'array',
            'collections.*' => 'integer|exists:collections,id',
            'images' => 'array',
            'images.*' => 'image|max:4096',
            'remove_images' => 'array',
            'card_image' => 'nullable|image|max:4096',
            'hover_image' => 'nullable|image|max:4096',
            'remove_hover' => 'boolean',
        ], ['code.regex' => 'The code may only use lowercase letters, numbers and dashes.']);

        $gallery = array_values(array_diff($product->gallery ?? [], $data['remove_images'] ?? []));
        foreach ($request->file('images', []) as $file) {
            $gallery[] = 'storage/'.$file->store('products', 'public');
        }
        if (! $gallery) {
            throw ValidationException::withMessages(['images' => 'Add at least one product photo.']);
        }

        // Filters read space-separated slugs: "Peacock Blue, Gold" -> "peacock-blue gold".
        $slugs = fn ($text) => collect(preg_split('/[,\s]+/', (string) $text))->filter()->map(fn ($t) => Str::slug($t))->unique()->implode(' ') ?: null;

        $product->fill([
            'title' => $data['title'],
            'page_title' => $data['page_title'] ?? null,
            'code' => ($data['code'] ?? null) ?: ($product->code ??Str::limit(Str::slug($data['title']), 30, '').'-'.Str::lower(Str::random(4))),
            'price' => $data['price'],
            'sku' => $data['sku'] ?? null,
            'stock' => $data['stock'],
            'category' => $data['category'],
            'color' => $slugs($data['color'] ?? null),
            'pattern' => $slugs($data['pattern'] ?? null),
            'fabric' => $slugs($data['fabric'] ?? null),
            'occasion' => $slugs($data['occasion'] ?? null),
            'blouse' => $data['blouse'],
            'product_details' => $data['product_details'] ?? null,
            'design_details' => $data['design_details'] ?? null,
            'material_care' => $data['material_care'] ?? null,
            'alt' => $data['alt'] ?? null,
            'is_new' => $data['is_new'] ?? false,
            'is_active' => $data['is_active'] ?? false,
            'gallery' => $gallery,
        ]);

        if ($request->hasFile('card_image') || ! $product->card_layers) {
            $src = $request->hasFile('card_image') ? 'storage/'.$request->file('card_image')->store('products', 'public') : $gallery[0];
            $product->card_layers = [['src' => $src, 'alt' => $product->title, 'fill' => true]];
        }
        if ($request->hasFile('hover_image')) {
            $product->hover_image = 'storage/'.$request->file('hover_image')->store('products', 'public');
        } elseif ($data['remove_hover'] ?? false) {
            $product->hover_image = null;
        } elseif (! $product->exists) {
            $product->hover_image = $gallery[1] ?? null;
        }
        $product->save();

        // Collections keep their order; a newly added product goes to the end of the grid.
        $current = $product->collections()->pluck('collection_product.position', 'collections.id');
        $product->collections()->sync(collect($data['collections'] ?? [])->mapWithKeys(fn ($id) => [
            $id => ['position' => $current[$id] ?? (int) Collection::find($id)->products()->max('collection_product.position') + 1],
        ])->all());
    }
}
