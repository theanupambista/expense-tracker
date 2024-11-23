<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'account_id',
        'category_id',
        'amount',
        'note',
        'date',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }


    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            $account = Account::find($transaction->account_id);
            if ($transaction->type === 'income') {
                $account->amount += $transaction->amount;
            } else {
                $account->amount -= $transaction->amount;
            }
            $account->save();
        });

        static::deleted(function ($transaction) {
            $account = Account::find($transaction->account_id);
            if ($transaction->type === 'income') {
                $account->amount -= $transaction->amount;
            } else {
                $account->amount += $transaction->amount;
            }
            $account->save();
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
