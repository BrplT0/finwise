<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // İlişkiler
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Hesaplama metodları
    public function getTotalIncomeAttribute()
    {
        return $this->incomes()->sum('amount');
    }

    public function getTotalExpenseAttribute()
    {
        return $this->expenses()->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return $this->total_income - $this->total_expense;
    }

    // Kategoriye göre toplam
    public function getIncomeByCategory($categoryId)
    {
        return $this->incomes()->where('category_id', $categoryId)->sum('amount');
    }

    public function getExpenseByCategory($categoryId)
    {
        return $this->expenses()->where('category_id', $categoryId)->sum('amount');
    }
}
