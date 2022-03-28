<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'ext_name'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * Get the name of employee.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $full_name = "";

        $full_name .= $this->last_name . ", ";
        $full_name .= $this->first_name;

        // middle initial
        $full_name .= ($this->middle_name && $this->middle_name !== ".") ? " " . $this->middle_name[0] . "." : "";

        // name ext
        $full_name .=  ($this->ext_name && $this->ext_name !== ".") ? " " . $this->ext_name: "";
        return $full_name;
    }
}
