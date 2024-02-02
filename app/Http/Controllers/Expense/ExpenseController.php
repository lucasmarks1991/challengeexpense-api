<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\DestroyRequest;
use App\Http\Requests\Expense\ShowRequest;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Http\Resources\Expense\ExpenseCollection;
use App\Http\Resources\Expense\ExpenseResource;
use App\Services\ExpenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseController extends Controller
{
    protected ExpenseService $service;

    public function __construct(ExpenseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): ResourceCollection
    {
        $expenses = $this->service->getAll();

        return new ExpenseCollection($expenses);
    }

    public function store(StoreRequest $request): JsonResource
    {
        $expense = $this->service->create(
            $request->only([
                'description',
                'occurred_date',
                'currency',
                'value',
            ])
        );

        return new ExpenseResource($expense);
    }

    public function show(ShowRequest $request, int $id): JsonResource
    {
        $expense = $this->service->get($id);

        return new ExpenseResource($expense);
    }

    public function update(UpdateRequest $request, int $id): JsonResource
    {
        $expense = $this->service->update(
            $request->only([
                'description',
                'occurred_date',
                'currency',
                'value',
            ]),
            $id
        );

        return new ExpenseResource($expense);
    }

    public function destroy(DestroyRequest $request, int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json();
    }
}
