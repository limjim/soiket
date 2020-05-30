<?php
/**
 * Created by PhpStorm.
 * User: KimTung
 * Date: 12/18/2019
 * Time: 1:34 PM
 */
namespace App\Repositories;

class Repository {

    public function create($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        return call_user_func(static::MODEL . '::create', $args);
    }

    public function update($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::where', array("id" => $args["id"])));
        $builder->update($args);
        $retVal = (call_user_func(static::MODEL . '::find', $args["id"]));
        return $retVal;
    }

    public function updateByField($args = null, $data = null) {
        if ($args == null || $data == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        $retVal = $builder->update($data);
        return $retVal;
    }

    public function delete($id = null) {
        if ($id == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        if (!is_array($id)) {
            $builder = (call_user_func(static::MODEL . '::where', ['id' => $id]));
            $retVal = $builder->delete();
        } else {
            $builder = (call_user_func(static::MODEL . '::query'));
            $retVal = $builder->whereIn('id', $id)->delete();
        }
        return $retVal;
    }

    public function deleteByFields($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        return $builder->delete();
    }

    public function checkExists($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        return $builder->exists();
    }

    public function count($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        return $builder->count();
    }

    public function getFirst($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        return $builder->first();
    }

    public function getLast($args = null) {
        if ($args == null) {
            throw new \InvalidArgumentException('Missing argument');
        }
        $builder = (call_user_func(static::MODEL . '::query'));
        foreach ($args as $key => $value) {
            $builder->where($key, '=', $value);
        }
        return $builder->last();
    }

    //call a static function of Model
    public function callStaticModelFunc() {
        $retVal = false;
        $numargs = func_num_args();
        $arglist = func_get_args();
        if ($numargs == 0) {
            throw new \InvalidArgumentException('Missing argument');
        } else if ($numargs == 1) {
            $retVal = call_user_func(static::MODEL . '::' . $arglist[0]);
        } else if ($numargs == 2) {
            $retVal = call_user_func(static::MODEL . '::' . $arglist[0], $arglist[1]);
        } else if ($numargs >= 3) {
            $argsOfFunc = [];
            for ($i = 1; $i <= count($arglist) - 1; $i++) {
                $argsOfFunc[] = $arglist[$i];
            }
            $retVal = call_user_func_array(static::MODEL . '::' . $arglist[0], $argsOfFunc);
        }
        return $retVal;
    }

    protected function executeQuery($query, $filter) {
        if (array_key_exists('orders', $filter) && count($filter['orders']) > 0) {
            foreach ($filter['orders'] as $key => $value) {
                $query->orderBy($key, $value);
            }
        }
        if (array_key_exists('pageSize', $filter) && array_key_exists('pageSize', $filter) && $filter['pageId'] != -1) {
            $query->forPage($filter['pageId'] + 1, $filter['pageSize']);
        }
        if (array_key_exists('metric', $filter) && $filter['metric'] == 'count') {
            return $query->count();
        } else {
            return $query->get();
        }
    }

    public function buildFilter($request, $columns = []) {
        $retVal = [];
        foreach($columns as $column) {
            if ($request->has($column) && $request->input($column) != '') {
                $retVal[$column] = $request->input($column);
            }
        }
        $retVal['pageId'] = ($request->has('pageId') && $request->input('pageId') != '') ? $request->input('pageId') : 0;
        $retVal['pageSize'] = ($request->has('pageSize') && $request->input('pageSize') != '') ? $request->input('pageSize') : 40;
        return $retVal;
    }
}