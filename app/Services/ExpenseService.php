<?php

namespace App\Services;

use App\Models\Expense;
use App\Notifications\Expense\ExpenseCreated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExpenseService extends Service
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Expense::query()->where('user_id', Auth::user()->id)->get();
    }

    /**
     * @param array $data
     *
     * @return Expense
     */
    public function create(array $data): Expense
    {
        $expense = new Expense();

        $expense->fill($data);
        $expense->user_id = Auth::user()->id;

        $expense->save();

        Auth::user()->notify(new ExpenseCreated($expense));

        return $expense;
    }

    /**
     * @param int $id
     *
     * @return Expense
     */
    public function get(int $id): Expense
    {
        return Expense::query()->where('user_id', Auth::user()->id)->findOrFail($id);
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return Expense
     */
    public function update(array $data, int $id): Expense
    {
        $expense = Expense::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        $expense->fill($data);
        $expense->save();

        return $expense;
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        try {
            $expense = Expense::query()->where('user_id', Auth::user()->id)->findOrFail($id);
            $expense->delete();
        } catch (\Throwable $e) {
            throw new ModelNotFoundException("Expense is invalid");
        }

        return true;
    }
}
