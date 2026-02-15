<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SocialPlatform;


class SocialPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = SocialPlatform::orderBy('sort_order')->get();
        return view('admin.social.index', compact('platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:social_platforms',
            'base_share_url' => 'required|string|url',
            'icon_class' => 'required|string',
            'color' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        SocialPlatform::create($validated);

        return redirect()->route('admin.social-platforms.index')
            ->with('success', 'Social platform created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialPlatform $socialPlatform)
    {
        return view('admin.social.edit', compact('socialPlatform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialPlatform $socialPlatform)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:social_platforms,slug,' . $socialPlatform->id,
            'base_share_url' => 'sometimes|required|string|url',
            'icon_class' => 'sometimes|required|string',
            'color' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $socialPlatform->update($validated);

        return redirect()->route('admin.social-platforms.index')
            ->with('success', 'Social platform updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPlatform $socialPlatform)
    {
        $socialPlatform->delete();

        return redirect()->route('admin.social-platforms.index')
            ->with('success', 'Social platform deleted successfully.');
    }

    /**
     * Update the sort order of social platforms.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:social_platforms,id',
        ]);

        foreach ($request->order as $index => $id) {
            SocialPlatform::where('id', $id)->update(['sort_order' => ($index + 1) * 10]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update global social share settings.
     */
    public function updateGlobal(Request $request)
    {
        $request->validate([
            'social_share_enabled' => 'required|boolean',
        ]);

        \App\Models\Setting::updateOrCreate(
            ['key' => 'social_share_enabled'],
            ['value' => $request->social_share_enabled ? '1' : '0']
        );

        return redirect()->back()->with('success', 'Global social settings updated.');
    }
}
