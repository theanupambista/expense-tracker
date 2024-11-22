<?php

namespace App\Http\Controllers\User;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return view('user.accounts.index', compact('accounts'));
    }


    public function store(StoreAccountRequest $request)
    {
        $account = Account::create(attributes: $request->validated());

        return redirect()->route('user.accounts.index')->with('success', 'Account added successfully!');
    }


    public function edit(Account $account)
    {
        return view('user.accounts.edit', compact('account'));
    }


    public function update(Request $request, Account $account)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'integer|min:0',
            'name' => 'string|max:255|unique:accounts,name,' . $account->id,
            'icon' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.accounts.index')
                ->withErrors($validator)
                ->withInput();
        }

        $account->update($validator->validated());

        return redirect()->route('user.accounts.index')->with('success', 'Account updated successfully!');
    }


    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('user.accounts.index')->with('success', "Account deleted successfully!");
    }
}
