<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\CreateTransactionApiRequest;
use App\Http\Requests\UpdateTransactionApiRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTransactionApiRequest $request)
    {
        $transaction = Transaction::create($request->only('user_id','amount','status'));
        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);
        if(empty($transaction)) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionApiRequest $request, string $id)
    {
        $transaction = Transaction::find($id);
        $transaction->update($request->only('amount','status'));
        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return response()->noContent();
    }
}
