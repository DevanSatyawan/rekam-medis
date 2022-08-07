<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\List_Pendaftaran;

class akses implements Rule
{
    protected $list;

    public function __construct(List_Pendaftaran $list)
    {
        $this->list = $list;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->list->latestMessage != null ? $this->list->latestMessage->created_at->lt(
            now()->subMinutes(5)
        ): null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mohon Untuk Menginputkan Data 5 Menit Kemudian';
    }
}
