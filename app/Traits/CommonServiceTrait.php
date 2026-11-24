<?php

namespace App\Traits;

trait CommonServiceTrait {

    /**
     * Get active model name
     */
    function getModel(){
        return $this->model;
    }

    /**
     * Find tag by id or throw error.
     * @param integer $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return any
     */
    public function findOrFail($id) {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Find tag by id or throw error.
     * @param integer $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return Tag
     */
    public function find($id) {
        return $this->getModel()->find($id);
    }

    /**
     * Find By Key
     * @param string|array $key
     * @param type $value
     * @return type
     */
    public function findByKey($key, $value = null) {
        if (is_array($key)) {
            return $this->getModel()->where($key)->first();
        }
        return $this->getModel()->where($key, $value)->first();
    }

    /**
     * Find By Key (throws exception)
     * @param string|array $key
     * @param type $value
     * @return type
     */
    public function findByKeyOrFail($key, $value = null) {
        if (is_array($key)) {
            return $this->getModel()->where($key)->firstOrFail();
        }
        return $this->getModel()->where($key, $value)->firstOrFail();
    }

    /**
     * Find Count Key
     * @param string|array $key
     * @param type $value
     * @return type
     */
    public function countByKey($key, $value = null) {
        if (is_array($key)) {
            return $this->getModel()->where($key)->count();
        }
        return $this->getModel()->where($key, $value)->count();
    }

    /**
     * Create or Update
     */
    public function createOrUpdate($data, $id = null){
        return ($id == null ? $this->create($data) : $this->updateById($id, $data));
    }

    /**
     * Create a new tag.
     * @param array $data
     * @return Tag
     */
    public function create($data) {
        return $this->getModel()->forceCreate($this->formatParams($data));
    }

    /**
     * Update By Id
     * @param array $data
     * @return Tag
     */
    public function updateById($id, $data = null) {
        if ($id) {
            return $this->getModel()->find($id)->update($this->formatParams($data, 'update'));
        }
        return false;
    }

    /**
     * Delete Muliple items from database
     * @return int number of rows deleted
     */
    function deleteMultiple($ids, $key = null) {
        $key = $key ? $key : $this->getPrimaryKey();
        return $this->getModel()->whereIn($key, $ids)->delete();
    }

    /**
     * Delete Item
     * @param type $id
     * @param type $key
     */
    function delete($id, $key = null) {
        $key = $key ? $key : $this->getPrimaryKey();
        return $this->getModel()->where($key, $id)->delete();
    }

    /**
     * List out all active items
     */
    function list($query = false){
        $q = $this->newQuery();
        if(method_exists($q,'active')){
            $q->active();
        }
        return $query ? $q : $q->get();
    }

    /**
     * Pluck from active list
     */
    function pluck($value, $key){
        return $this->list(true)->pluck($value, $key);
    }

    /**
     * Get All Items with where/callback filters
     * @param type $where
     */
    function all($where = null) {
        $q = $this->newQuery();
        if ($where) {
            if (is_callable($where) == false) {
                $q->where($where)->get();
            } else{
                $where($q);
            }
        }
        return $q->get();
    }

    /**
     * Build Query on that model
     * @return type
     */
    function newQuery() {
        return $this->getModel()->whereNotNull($this->getPrimaryKey());
    }

    /**
     * Formats parameters
     * @param type $params
     * @param type $mode
     * @return type
     */
    public function formatParams($params, $mode = 'create') {
        unset($params['_token']);
        if ($mode == 'update') {
            unset($params[$this->getPrimaryKey()]);
        }
        return $params;
    }

    /**
     * Getprimary key of active Model
     * @return type
     */
    function getPrimaryKey() {
        return $this->getModel()->getKeyName();
    }
    /**
     * Paginate Model
     */
    function paginate($page = 1, $perpage = 10, $offset = -1 ,$seach = null ,$callback = null){
        $page  = $page  ? $page : 1;
        $offset = $offset == -1 ? ($page - 1) * $perpage : $offset ;
        $q = $this->newQuery();
        if(method_exists($q,'active')){
            $q->active();
        }
        if($seach){
            if(method_exists($q,'search')){
                $q->search();
            }else {
                $q = self::applySearch($q);
            }
        }
        
        if($callback){
            $callback($q);
        }

        $countQuery = clone $q;
        $q->skip($offset )->take($perpage);

        $data = [
            'total' => $countQuery->count(),
            'page' => $page,
            'perpage' => $perpage,
            'offset' => $offset ,
            'result' => $q->get(),
        ];
        return $data;
    }


    function applySearch($q){
        $whereRaw = "CONCAT (";
        $columns = self:: generalSearchOn();

        foreach($columns as $col){
            $query .= "`" . $key . "`, ' ',";
        }
        $query = rtrim($query, ',');
        $query .= ") LIKE '%" . $value . "%'";

        if(count($columns) > 0){
            $q->whereRaw($generalQuery);
        }
        return $q;

    }

    /**
     * General search column for this model
     */
    function generalSearchOn(){
        return [];
    }

}
