<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\DestroyRequest;
use App\Http\Requests\Expense\ShowRequest;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Http\Resources\Expense\ExpenseCollection;
use App\Http\Resources\Expense\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * @param Request $request
     *
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $expenses = Auth::user()->expenses;

        return new ExpenseCollection($expenses);
    }

    /**
     * @param StoreRequest $request
     *
     * @return JsonResource
     */
    public function store(StoreRequest $request): JsonResource
    {
        $data = $request->only([
            'description',
            'occurred_date',
            'currency',
            'value',
        ]);

        $data['user_id'] = Auth::user()->id;

        $expense = Expense::query()->create($data);

        return new ExpenseResource($expense);
    }

    /**
     * @param ShowRequest $request
     * @param int $id
     *
     * @return JsonResource
     */
    public function show(ShowRequest $request, Expense $expense): JsonResource
    {
        $this->authorize('view', $expense);

        return new ExpenseResource($expense);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     *
     * @return JsonResource
     */
    public function update(UpdateRequest $request, Expense $expense): JsonResource
    {
        $this->authorize('update', $expense);

        $expense->fill(
            $request->only([
                'description',
                'occurred_date',
                'currency',
                'value',
            ])
        );

        $expense->save();

        return new ExpenseResource($expense);
    }

    /**
     * @param DestroyRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(DestroyRequest $request, Expense $expense): JsonResponse
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return response()->json();
    }
}
