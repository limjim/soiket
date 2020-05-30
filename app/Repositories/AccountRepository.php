<?php
/**
 * Created by PhpStorm.
 * User: KimTung
 * Date: 12/18/2019
 * Time: 1:39 PM
 */

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends Repository {
    const MODEL = Account::class;

    public function create($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $retVal = false;
        try {
            $retVal = Account::create($args);
        } catch (\Exception $ex) {
            \Log::info("Error create deal: " . $ex->getMessage());
        }
        return $retVal;
    }

    public function find($filter) {
        if (array_key_exists('id', $filter)) {
            return Account::findOrFail($filter['id']);
        }
        $query = Account::query();
        if (array_key_exists('with', $filter)) {
            $query->with($filter['with']);
        }
        if (array_key_exists('full_name', $filter)) {
            $query->where('full_name', 'LIKE', '%' . $filter['full_name'] . '%');
        }
        if (array_key_exists('columns', $filter)) {
            $query->select(DB::raw($filter['columns']));
        }
        return $this->executeQuery($query, $filter);
        
    }



}