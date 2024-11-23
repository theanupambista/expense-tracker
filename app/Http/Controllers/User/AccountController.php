<?php

namespace App\Http\Controllers\User;

use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Transaction;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return view('user.accounts.index', compact('accounts'));
    }


    public function store(StoreAccountRequest $request)
    {
        $data = [...$request->validated(),  'user_id' => Auth::user()->id];

        Account::create($data);

        return redirect()->route('user.accounts.index')->with('success', 'Account added successfully!');
    }


    public function edit(Account $account)
    {
        if ($account->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('user.accounts.edit', compact('account'));
    }


    public function update(UpdateAccountRequest $request, Account $account)
    {
        $account->update($request->validated());

        return redirect()->route('user.accounts.index')->with('success', 'Account updated successfully!');
    }


    public function destroy(Account $account)
    {
        if ($account->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }
        // check if account have transactions
        if (Transaction::where('account_id', $account->id)->exists()) {
            return redirect()->route('user.accounts.index')->with('success', "This account has transactions!");
        }
        $account->delete();

        return redirect()->route('user.accounts.index')->with('success', "Account deleted successfully!");
    }
}
