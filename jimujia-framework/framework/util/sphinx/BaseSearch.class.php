<?php

//判断是否有php集成
if (!class_exists('SphinxClient')) {
    include_once FRAMEWORK_PATH . '/util/sphinx/sphinxapi.php';
}

class BaseSearch {
    //相等
    private $_filterArray = array();
    //范围
    private $_rangeArray = array();
    //排序字段
    private $_sortby = '';
    //排序规则
    private $_sortmode = 'desc';
    //限数
    private $_limit = 20;
    //偏移量
    private $_offset = 0;
    //搜索词
    private $_keyword = '';

    public $searchFilter = array();

    private $_handle;
    /**
     *以数组条件传入参数,获取车源数据
     *
     */
    public function __construct($config) {
        $this->_handle = $this->createHandle($config['host'], $config['port']);
    }

    private static function createHandle($host, $port) {
        $handle = new SphinxClient();
        $handle->SetServer($host, $port);
        $handle->SetConnectTimeout(1);
        $handle->SetArrayResult(true);
        return $handle;
    }

    /**
     *获取车源数据id
     *
     */
    public function getIds() {
        $handle  = $this->_handle;
        $handle->SetLimits($this->_offset, $this->_limit);
        if ($this->_sortby) {
            $handle->SetSortMode(SPH_SORT_EXTENDED, $this->_sortby.' '. $this->_sortmode);
        }
        if (!empty($this->_filterArray)) {
            foreach ($this->_filterArray as $field=>$value) {
                $handle->SetFilter($field, array($value));
            }
        }
        if (!empty($this->_rangeArray)) {
            foreach ($this->_rangeArray as $field=>$value) {
                if ($this->searchFilter[$field] == 'int') {
                    $handle->SetFilterRange($field, $value[0], $value[1]);
                } else {
                    $handle->SetFilterFloatRange($field, $value[0], $value[1]);
                }
            }
        }
        $res = $handle->Query($this->_keyword);
        $ids = array();
        if (!empty($res['matches'])) {
            foreach ($res['matches'] as $item) {
                $ids[] = $item['id'];
            }
        }
        return array($ids, $res['total_found']);
    }


    /**
     * 准备过滤条件
     *
     */
    public function prefreFilter($filter) {
        if (empty($filter)) {
            trigger_error('无检索条件');
        }
        foreach ($filter as $field=>$value) {
            switch($field) {
                case 'offset':
                    $this->setOffset($value);
                    break;
                case 'limit':
                    $this->setLimit($value);
                    break;
                case 'sort':
                    $this->setSortBy($value[0], $value[1]);
                    break;
                case 'kw':
                    $this->setKw($value);
                    break;
                default:
                    if (!isset($this->searchFilter[$field])) {
                        break;
                    }
                    if (is_array($value)) {
                        $this->setRange($field, $value);
                    } else {
                        $this->setFilter($field, $value);
                    }
                    break;
             }
        }
    }

    public function setKw($keyword) {
        $this->_keyword = $keyword;
    }

    public function setFilter($field, $value) {
        $this->_filterArray[$field] = $value;
    }

    //必须指定min和max,如$value = array(100,200);
    public function setRange($field, $value) {
        if (!is_array($value)) {
            return;
        }
        $this->_rangeArray[$field] = $value;
    }

    public function setLimit($limit) {
        $this->_limit = $limit;
    }

    public function setOffset($offset) {
        $this->_offset = $offset;
    }

    public function setSortBy($sort, $mode) {
        $this->_sortby = $sort;
        $this->_sortmode = $mode;
    }
}
