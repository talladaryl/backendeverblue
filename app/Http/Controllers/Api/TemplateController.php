<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\StoreTemplateRequest;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        return response()->json(Template::all());
    }

    public function store(StoreTemplateRequest $request)
    {
        $data = $request->validated();

        // Assure-toi que 'structure' a toujours une valeur pour éviter l'erreur SQL
        $data['structure'] = $data['structure'] ?? '{}';

        $template = Template::create($data);

        return response()->json($template, 201);
    }

    public function show(Template $template)
    {
        return response()->json($template);
    }

    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $data = $request->validated();
        $data['structure'] = $data['structure'] ?? $template->structure;

        $template->update($data);

        return response()->json($template);
    }

    public function destroy(Template $template)
    {
        $template->delete();

        return response()->json(['message' => 'Template deleted successfully']);
    }
}