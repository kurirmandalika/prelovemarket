<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProfileRequest;
use App\Models\SellerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('dashboard.seller-profile.edit', [
            'profile' => $request->user()->sellerProfile,
        ]);
    }

    public function update(SellerProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $profile = $request->user()->sellerProfile;

        if (! $profile || $profile->shop_name !== $data['shop_name']) {
            $data['slug'] = $this->uniqueSlug($data['shop_name'], $profile?->id);
        }

        SellerProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data + ['user_id' => $request->user()->id]
        );

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Profil penjual berhasil disimpan.');
    }

    private function uniqueSlug(string $shopName, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($shopName);
        $slug = $baseSlug;
        $counter = 2;

        while (SellerProfile::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
