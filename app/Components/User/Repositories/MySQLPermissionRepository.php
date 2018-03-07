<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/6/2017
 * Time: 5:07 PM
 */

namespace App\Components\User\Repositories;

use App\Components\Core\Result;
use App\Components\Core\Utilities\Helpers;
use App\Components\User\Contracts\IPermissionRepository;
use App\Components\User\Models\Permission;

class MySQLPermissionRepository implements IPermissionRepository
{
    /**
     * index items
     *
     * @param array $params
     * @return Result
     */
    public function index($params)
    {
        $title = Helpers::hasValue($params['title']);
        $orderBy = Helpers::hasValue($params['order_by'],'id');
        $orderSort = Helpers::hasValue($params['order_sort'],'desc');
        $paginate = Helpers::hasValue($params['paginate'],'yes');
        $perPage = Helpers::hasValue($params['per_page'],10);

        $q = Permission::with([])->orderBy($orderBy,$orderSort);

        (!$title) ?: $q = $q->where('title','like',"%{$title}%");

        if($paginate==='yes')
        {
            return new Result(true,Result::MESSAGE_SUCCESS_LIST,$q->paginate($perPage));
        }

        return new Result(true,Result::MESSAGE_SUCCESS_LIST,$q->get());
    }

    /**
     * create new item
     *
     * @param array $payload
     * @return Result
     */
    public function create($payload)
    {
        $Permission = Permission::create([
           'title' => $payload['title'],
           'description' => $payload['description'],
           'key' => $payload['key'],
        ]);

        if(!$Permission) return new Result(false,Result::MESSAGE_NOT_FOUND,null,404);

        return new Result(true,Result::MESSAGE_SUCCESS_CREATE,$Permission,201);
    }

    /**
     * update item
     *
     * @param int $id
     * @param array $payload
     * @return Result
     */
    public function update($id, $payload)
    {
        $Permission = Permission::find($id);

        if(!$Permission) return new Result(false,Result::MESSAGE_NOT_FOUND,null,404);

        $Permission->title = $payload['title'];
        $Permission->description = $payload['description'];
        $Permission->key = $payload['key'];

        if(!$Permission->save()) return new Result(false,Result::MESSAGE_FAILED_UPDATE,null,400);

        return new Result(true,Result::MESSAGE_SUCCESS_UPDATE,$Permission,200);
    }

    /**
     * delete by id
     *
     * @param int $id
     * @return Result
     */
    public function delete($id)
    {
        $Permission = Permission::find($id);

        if(!$Permission) return new Result(false,Result::MESSAGE_NOT_FOUND,null,400);

        $Permission->delete();

        return new Result(true,Result::MESSAGE_SUCCESS_DELETE,null,200);
    }

    /**
     * get resource by id
     *
     * @param $id
     * @return Result
     */
    public function get($id)
    {
        $permission = Permission::find($id);

        if(!$permission) return new Result(false,Result::MESSAGE_NOT_FOUND,null,404);

        return new Result(true,Result::MESSAGE_SUCCESS,$permission,200);
    }
}