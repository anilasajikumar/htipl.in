<?php
namespace App\Http\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/* 
 * Datatable Helper
 * @author Jithin S
 * @date 09-Aug-2018
 * @modified 08-Aug-2019
 * @version 1.1
 */

/*
============================================================================
 * Usage sameple
============================================================================

  $data =  (new Datatable('App\Model\Packages',$request))
         ->select(['id','title','type','description','agent_limit','status'])
         ->generalSearchOn(['title','description'])
         ->getData();
 
 */


class Datatable {

protected $model_name = null;
protected $intance = null;
protected $pagination = [];
protected $pageSort = [];
protected $search = [];
protected $select = "*";
protected $columns = [];
protected $dbQuery = null;

/* Pagination Parameters */
protected $perpage = -1;
protected $offset = 0;
protected $page = 0;
protected $pages = 1;

/* Sorting parameters */
protected $defaultSortOrder = null;
protected $defaultSortBy = null;
protected $sortOrder = null;
protected $sortBy = null;
protected $sortfieldMap = null;
protected $hasGroupBy = false;

protected $request = null;

public function __construct($model_name, Request $request, $defaultSortBy = 'id', $defaultSortOrder = 'desc') {

    $this->model_name = $model_name;
    $this->request = $request;
    $this->defaultSortBy = $defaultSortBy;
    $this->defaultSortOrder = $defaultSortOrder;
    $this->search = ['generalSearch' => $this->request->get('search')['value']];

    $this->_initialyze();
}

public function __call($method, $arguments) {

    if (method_exists($this, $method)) {
        return call_user_func_array(array($this, $method), $arguments);
    } else {
        if ('groupBy' == $method) {
            $this->hasGroupBy = true;
        }
        call_user_func_array(array($this->dbQuery, $method), $arguments);
        return $this;
    }
}

/**
 * Set global  Properties
 */
function _initialyze() {

    $model_name = $this->model_name;
    $this->intance = new $model_name;

    $this->perpage =(int) $this->request->get('length',0);
    $this->offset =  (int) $this->request->get('start',0);
    $this->page = (int) ($this->offset + $this->perpage)/$this->perpage ;
    $this->pages = 1;

    $this->defaultSortBy = $this->defaultSortBy == 'id' ? $this->intance->getKeyName() : $this->defaultSortBy;
  
    $this->sortOrder =$this->request->get('order')[0]['dir'];
    $this->sortBy = $this->request->get('order')[0]['column'];
    $this->sortBy = $this->request->get('columns')[$this->sortBy ]['data'];

    if ($this->model_name != null) {
        $this->dbQuery = $model_name::whereNotNull("{$this->intance->getTable()}.{$this->intance->getKeyName()}");
    }
}

function select($fields = '*') {
    $this->select = $fields;
    return $this;
}

function generalSearchOn($columns = []) {
    $this->columns = $columns;
    return $this;
}

function setPage($page = 1, $perpage = null) {
    $this->page = $page;
    if ($perpage != null) {
        $this->perpag = $perpage;
    }
    return $this;
}

function setSortFieldMap($data = []) {
    $this->sortfieldMap = $data;

    if (isset($this->sortfieldMap[$this->sortBy])) {
        $this->sortBy = $this->sortfieldMap[$this->sortBy];
    }
    if (isset($this->sortfieldMap[$this->defaultSortBy])) {
        $this->defaultSortBy = $this->sortfieldMap[$this->defaultSortBy];
    }
    return $this;
}

/**
 * Get filtered count of table
 * @return int
 */
function getTotalCount() {
    $clone = clone $this->dbQuery;
    $clone->select(\DB::raw('count(*) as count'));
    $clone = $this->_applyFilter($clone, $this->search, $this->columns);
    return $this->hasGroupBy ? $clone->get()->count() : $clone->count();
}

/**
 * Get sorted datatable data
 * @param type $sortBy
 * @param type $sortOrder
 * @param type $perpage
 * @param type $offset
 * @return type
 */
function getFilteredData($sortBy, $sortOrder, $perpage, $offset) {

    $clone = clone $this->dbQuery;
    $clone->select($this->select);
    $clone = $this->_applyFilter($clone, $this->search, $this->columns);
    if ($perpage != -1) {
        $clone->offset($offset)->limit($perpage);
    }

    return $clone->orderBy($sortBy, $sortOrder)->get();
}

public function getData($callback = null) {

    $total = $this->getTotalCount();

    // $perpage 0; get all data
    if ($this->perpage > 0) {
        $this->pages = ceil($total / $this->perpage); // calculate total pages
        $this->page = max($this->page, 1);            // get 1 page when $_REQUEST['page'] <= 0
        $this->page = min($this->page, $this->pages);       // get last page when $_REQUEST['page'] > $totalPages
        $this->offset = ( $this->page - 1 ) * $this->perpage;
        if ($this->offset < 0) {
            $this->offset = 0;
        }
    }
    $this->sortOrder = !empty($this->sortOrder) ? $this->sortOrder : $this->defaultSortOrder;
    $this->sortBy = !empty($this->sortBy) ? $this->sortBy : $this->defaultSortBy;


    $data = $this->getFilteredData($this->sortBy, $this->sortOrder, $this->perpage, $this->offset);

    if (is_callable($callback)) {
        $data = $data->toArray();
        foreach ($data as $index => $row) {
            $callbackResult = $callback($row);
            $data[$index] = empty($callbackResult) ? $row : $callbackResult;
        }
    }


    $result = array(
        'meta' => array(
            'page' => $this->page,
            'pages' => $this->pages,
            'perpage' => $this->perpage,
            'total' => $total,
            'sort' => $this->sortOrder,
            'field' => $this->sortBy,
        ),
        'data' => $data
    );
    
      $result = array(
        "draw"            =>  $this->request->get('draw',1),
        "recordsTotal"    => $total,
        "recordsFiltered" => $total,
        "data"            => $data,
        'meta' => array(
            'page' => $this->page,
            'pages' => $this->pages,
            'perpage' => $this->perpage,
            'total' => $total,
            'sort' => $this->sortOrder,
            'field' => $this->sortBy,
        ),
    );

    return $result;
}

function _getTableName() {
    return $this->intance->getTable();
}

public function _getTableColumns() {
    return empty($this->columns) ?
            \Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing($this->_getTableName()) : $this->columns;
}

public function _applyFilter($dbQuery, $filterParams, $columns) {

    if (!empty($filterParams)) {
        foreach ($filterParams as $key => $value) {
            if (strpos($key, 'generalSearch') !== false) {
                if (($generalQuery = $this->_generateConcatQuery($columns, $value)) != null) {
                    $dbQuery->whereRaw($generalQuery);
                }
            } else if ($key == 'generalSearchAdmin') {
                if (($generalQuery = $this->_generateConcatQuery($columns, $value)) != null) {
                    $dbQuery->whereRaw($generalQuery);
                }
            } else {
                $dbQuery->whereRaw(\DB::raw("$key='$value'"));
            }
        }
    }

    return $dbQuery;
}

private function _generateConcatQuery($columns, $value) {
    $exclude = array('id', 'password', 'created_at', 'created_by', 'updated_by', 'updated_at', 'invite_code');
    $query = "CONCAT (";
    $c = 0;
    foreach ($columns as $key) {
        if (!in_array($key, $exclude)) {
            if (strpos($key, '.') == FALSE) {
                $query .= "`" . $key . "`, ' ',";
            } else if (is_a($key, 'Illuminate\Database\Query\Expression')) {
                $query .= $key . ", ' ',";
            } else {
                list($table, $column) = explode('.', $key);
                $query .= "`" . $table . "`.`" . $column . "`, ' ',";
            }
            $c++;
        }
    }
    $query = rtrim($query, ',');
    $query .= ") LIKE '%" . $value . "%'";
    if ($c > 0 && strlen($value) > 0) {
        return $query;
    }
    return null;
}

}