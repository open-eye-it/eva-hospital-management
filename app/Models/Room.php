<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'rm_id',
        'rm_added_by',
        'rm_updated_by',
        'rm_building',
        'rm_floor',
        'rm_ward',
        'rm_no',
        'rm_charge',
        'rm_busy',
        'rm_status'
    ];

    public function checkBuildingFloorWardRoomExist($rm_building, $rm_floor, $rm_ward, $rm_no)
    {
        return static::where(['rm_building' => $rm_building, 'rm_floor' => $rm_floor, 'rm_ward' => $rm_ward, 'rm_no' => $rm_no])->first();
    }

    public function checkBuildingFloorWardRoomExistIgnore_rm_id($rm_id, $rm_building, $rm_floor, $rm_ward, $rm_no)
    {
        return static::where('rm_id', '!=', $rm_id)->where(['rm_building' => $rm_building, 'rm_floor' => $rm_floor, 'rm_ward' => $rm_ward, 'rm_no' => $rm_no])->first();
    }

    public function insertRoom($data)
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

    public function getListforIPD($filter, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $data->where('rm_status', $filter['rm_status']);
        $data->where('rm_busy', $filter['rm_busy']);
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }
    public function getListIgnoreID($filter, $order_by = ['created_at', 'desc'])
    {
        $data = static::select('*');
        $data->where('rm_status', $filter['rm_status']);
        $data->where(function ($query) use ($filter) {
            $query->where('rm_busy', $filter['rm_busy']);
            $query->orWhere('rm_id', $filter['rm_id']);
        });
        $data->orderBy($order_by[0], $order_by[1]);
        $output = $data->get();
        return $output;
    }

    public function updateRoom($data, $rm_id)
    {
        return static::where('rm_id', $rm_id)->update(\Arr::only($data, $this->fillable));
    }

    public function FilterData($data, $filterData)
    {
        $search_text = isset($filterData['search_text']) ? $filterData['search_text'] : '';
        $rm_building = isset($filterData['rm_building']) ? $filterData['rm_building'] : '';
        $rm_floor    = isset($filterData['rm_floor']) ? $filterData['rm_floor'] : '';
        $rm_ward     = isset($filterData['rm_ward']) ? $filterData['rm_ward'] : '';
        $rm_no       = isset($filterData['rm_no']) ? $filterData['rm_no'] : '';
        $rm_status   = isset($filterData['rm_status']) ? $filterData['rm_status'] : '';
        $rm_busy     = isset($filterData['rm_busy']) ? $filterData['rm_busy'] : '';
        if (isset($rm_building) && $rm_building != '') {
            $data->where('rm_building', $rm_building);
        }
        if (isset($rm_floor) && $rm_floor != '') {
            $data->where('rm_floor', $rm_floor);
        }
        if (isset($rm_ward) && $rm_ward != '') {
            $data->where('rm_ward', $rm_ward);
        }
        if (isset($rm_no) && $rm_no != '') {
            $data->where('rm_no', $rm_no);
        }
        if (isset($rm_status) && $rm_status != '') {
            $data->where('rm_status', $rm_status);
        }
        if (isset($rm_busy) && $rm_busy != '') {
            $data->where('rm_busy', $rm_busy);
        }
        if (isset($search_text) && $search_text != '') {
            $data->where(function ($query) use ($search_text) {
                $query->where('rm_no', 'LIKE', '%' . $search_text . '%');
                $query->orWhere('rm_charge', 'LIKE', '%' . $search_text . '%');
            });
        }
    }

    public function singlRoom($rm_id)
    {
        return static::where('rm_id', $rm_id)->first();
    }

    public function buildingList()
    {
        return static::select('rm_building')->where('rm_status', 1)->orderBy('rm_building', 'ASC')->get()->unique('rm_building');
    }

    public function floorList($rm_building)
    {
        if ($rm_building != '') {
            return static::select('rm_floor')->where(['rm_status' =>  1, 'rm_building' => $rm_building])->orderBy('rm_floor', 'ASC')->get()->unique('rm_floor');
        } else {
            return static::select('rm_floor')->where('rm_status', 1)->orderBy('rm_floor', 'ASC')->get()->unique('rm_floor');
        }
    }

    public function wardList($rm_building, $rm_floor)
    {
        if ($rm_building != '' && $rm_floor != '') {
            return static::select('rm_ward')->where(['rm_building' => $rm_building, 'rm_floor' =>  $rm_floor])->orderBy('rm_ward', 'ASC')->get()->unique('rm_ward');
        } else {
            return static::select('rm_ward')->where('rm_status', 1)->orderBy('rm_ward', 'ASC')->get()->unique('rm_ward');
        }
    }

    public function roomList($rm_building, $rm_floor, $rm_ward)
    {
        if ($rm_building != '' && $rm_floor != '' && $rm_ward != '') {
            return static::select('rm_no')->where(['rm_building' => $rm_building, 'rm_floor' =>  $rm_floor, 'rm_ward' => $rm_ward])->orderBy('rm_no', 'ASC')->get()->unique('rm_no');
        } else {
            return static::select('rm_room')->where('rm_status', 1)->orderBy('rm_room', 'ASC')->get()->unique('rm_room');
        }
    }

    public function floorFilter($rm_building)
    {
        return static::select('rm_floor')->where('rm_building', $rm_building)->orderBy('rm_floor', 'ASC')->get()->unique('rm_floor');
    }

    public function wardFilter($rm_building, $rm_floor)
    {
        return static::select('rm_ward')->where(['rm_building' => $rm_building, 'rm_floor' =>  $rm_floor])->orderBy('rm_ward', 'ASC')->get()->unique('rm_ward');
    }

    public function roomFilter($rm_building, $rm_floor, $rm_ward)
    {
        return static::select('rm_no')->where(['rm_building' => $rm_building, 'rm_floor' =>  $rm_floor, 'rm_ward' => $rm_ward])->orderBy('rm_no', 'ASC')->get()->unique('rm_no');
    }

    /* Relationship */
    public function AddedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rm_added_by');
    }

    public function UpdatedByData()
    {
        return $this->hasOne(User::class, 'user_id', 'rm_updated_by');
    }
}
