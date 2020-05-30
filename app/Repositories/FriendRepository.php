<?php
/**
 * Created by PhpStorm.
 * User: KimTung
 * Date: 12/18/2019
 * Time: 1:39 PM
 */

namespace App\Repositories;

use App\Models\Friend;

class FriendRepository extends Repository {
    const MODEL = Deal::class;

    public function create($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $retVal = false;
        try {
            $retVal = Friend::create($args);
        } catch (\Exception $ex) {
            \Log::info("Error create deal: " . $ex->getMessage());
        }
        return $retVal;
    }

    public function find($filter) {
        if (array_key_exists('id', $filter)) {
            return Friend::findOrFail($filter['id']);
        }
        $query = Friend::query();
        if (array_key_exists('with', $filter)) {
            $query->with($filter['with']);
        }
        if (array_key_exists('full_name', $filter)) {
            $query->where('full_name', 'LIKE', '%' . $filter['full_name'] . '%');
        }
        if (array_key_exists('gender', $filter)) {
    
            $query->where('gender', '=', $filter['gender']);
        }
        if (array_key_exists('account_id', $filter)) {
            $query->where('account_id', '=', $filter['account_id']);
        }
        if (array_key_exists('columns', $filter)) {
            $query->select(DB::raw($filter['columns']));
        }
        return $this->executeQuery($query, $filter);
        
    }



}