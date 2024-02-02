<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExpenseService extends Service
{
    public function getAll(): Collection
    {
        return Expense::query()->where('user_id', Auth::user()->id)->get();
    }

    public function create(array $data): Expense
    {
        $expense = new Expense();

        $expense->fill($data);
        $expense->user_id = Auth::user()->id;

        $expense->save();

        return $expense;
    }

    public function get(int $id): Expense
    {
        return Expense::query()->where('user_id', Auth::user()->id)->findOrFail($id);
    }

    public function update(array $data, int $id): Expense
    {
        $expense = Expense::query()->where('user_id', Auth::user()->id)->findOrFail($id);

        $expense->fill($data);
        $expense->save();

        return $expense;
    }

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
