<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::latest()->where("receiver_id", auth()->user()->id)->orWhere("sender_id", auth()->user()->id)->get();
        return view("transactions", compact("transactions"));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",
            "amount" => "numeric|min:1"
        ]);
        $receiver = User::where("email", $request->email)->first();
        if ($receiver->email==auth()->user()->email)
            return redirect()->back()->withErrors("You can't send money to yourself");

        $balance = auth()->user()->balance;
        $transactionFee = 0;
        if ($request->amount >= 10000 && $request->amount <= 100000) {
            $transactionFee = 200;
        } else if ($request->amount > 100000)
            $transactionFee = 1000;
        if (($transactionFee + $request->amount) > $balance)
            return redirect()->back()->withErrors("You don't have enough amount");

        Transaction::create([
            "amount" => $request->amount,
            "receiver_id" => $receiver->id,
            "sender_id" => auth()->user()->id,
            "deducted_fee" => $transactionFee,
            "type" => "send",
        ]);
        $receiver->update(["balance" => $receiver->balance + $request->amount]);
        User::find(auth()->user()->id)->update(["balance" => auth()->user()->balance - ($request->amount + $transactionFee)]);
        return redirect()->back()->with("message", "Money sent successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
