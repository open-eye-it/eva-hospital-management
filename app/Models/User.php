<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'person_name',
        'country_code',
        'dial_code',
        'contactno',
        'address',
        'cat_id',
        'added_by',
        'updated_by',
        'user_status',
        'show_to_doctor_list'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function checkUserOrEmailExist($name, $email)
    {
        return static::where('name', $name)->orWhere('email', $email)->first();
    }

    public function singlUser($user_id)
    {
        return static::where('user_id', $user_id)->first();
    }

    public function insertUser($data)
    {
        return static::create(\Arr::only($data, $this->fillable));
    }

    public function getList($filterData = [], $paginate = true, $limit = 10, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $this->FilterData($data, $filterData);
        $data->orderBy($order_by[0], $order_by[1]);
        if ($paginate === true) :
            $output = $data->paginate((int)$limit);
        else :
            $data->limit((int)$limit);
            $output = $data->get();
        endif;
        return $output;
    }

    public function updateUser($data, $user_id)
    {
        return static::where('user_id', $user_id)->update(\Arr::only($data, $this->fillable));
    }

    public function updateStatus($data, $user_id)
    {
        return DB::table('users')->where('user_id', $user_id)->update($data);
    }

    public function FilterData($data, $filterData)
    {
        $search_text    = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        if (isset($search_text) && $search_text != '') {
            $data->where('name', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('email', 'LIKE', '%' . $search_text . '%');
            $data->orWhere('person_name', 'LIKE', '%' . $search_text . '%');
        }
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'updated_by');
    }
}
