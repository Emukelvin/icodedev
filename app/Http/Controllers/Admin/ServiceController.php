<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\PricingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('projects')->orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service;
        return view('admin.services.form', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'technologies' => 'nullable|string',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'technologies' => 'nullable|string',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        }
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted.');
    }
}
