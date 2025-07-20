<?php

namespace App\Http\Controllers;

use App\Http\Requests\Training\StoreTrainingRequest;
use App\Models\Training;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(): JsonResponse
    {
        $trainings = Training::all();

        return new JsonResponse([
            'success' => true,
            'message' => 'Treinamentos recuperados com sucesso.',
            'trainings' => $trainings
        ], 200);
    }

    public function show($hash_id): JsonResponse
    {
        $training = Training::where('hash_id', $hash_id)->firstOrFail();
        return new JsonResponse([
            'success' => true,
            'message' => 'Treinamento recuperado com sucesso.',
            'training' => $training
        ], 200);
    }

    public function store(StoreTrainingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $training = Training::create($data);

        return new JsonResponse([
            'success' => true,
            'message' => 'Treinamento criado com sucesso.',
            'training' => $training
        ], 201);
    }

    public function update(StoreTrainingRequest $request, $hash_id): JsonResponse
    {
        $data = $request->validated();
        $training = Training::where('hash_id', $hash_id)->firstOrFail();
        $training->update($data);

        return new JsonResponse([
            'success' => true,
            'message' => 'Treinamento atualizado com sucesso.',
            'training' => $training
        ], 200);
    }

    public function destroy($hash_id): JsonResponse
    {
        $training = Training::where('hash_id', $hash_id)->firstOrFail();
        $training->delete();

        return new JsonResponse([
            'success' => true,
            'message' => 'Treinamento deletado com sucesso.'
        ], 200);
    }
}
