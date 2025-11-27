<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Models\Asset;

class AssetController extends Controller
{
    public function index()
    {
        return response()->json(Asset::all());
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->validated());

        return response()->json($asset, 201);
    }

    public function show(Asset $asset)
    {
        return response()->json($asset->load('event'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        return response()->json($asset);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
