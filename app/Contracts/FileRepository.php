<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/9/2017
 * Time: 10:03 PM
 */

namespace App\Contracts;


use App\Repositories\Result;
use Illuminate\Http\Request;

interface FileRepository
{
    /**
     * list resource
     *
     * @param array $params
     * @return Result
     */
    public function index($params);

    /**
     * create resource
     *
     * @param array $data
     * @return Result
     */
    public function create($data);

    /**
     * get resource by id
     *
     * @param $id
     * @return Result
     */
    public function get($id);

    /**
     * update resource
     *
     * @param int $id
     * @param array $data
     * @return Result
     */
    public function update($id, $data);

    /**
     * delete resource by id
     *
     * @param int $id
     * @return Result
     */
    public function delete($id);

    /**
     * @param Request $request
     * @return Result
     */
    public function upload($request);
}