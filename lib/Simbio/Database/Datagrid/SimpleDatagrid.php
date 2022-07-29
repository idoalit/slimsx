<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-28 00:56
 * @File name           : SimpleDatagrid.php
 */

namespace SLiMS\Simbio\Database\Datagrid;


use Exception;
use utility;

class SimpleDatagrid extends Datagrid
{
  private $db;
  private $table;
  private $row_to_show = 10;
  protected $editable = true;
  private $empty_value;
  private $filter = [];

  /**
   * @param $dbs
   * @return SimpleDatagrid
   */
  static function init($dbs, $table)
  {
    $datagrid = new static($dbs);
    $datagrid->setTable($table);
    return $datagrid;
  }

  public function __construct($obj_db)
  {
    parent::__construct('id="dataList" class="s-table table"');
    $this->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
    $this->edit_link_text = '&nbsp;';
    $this->chbox_form_URL = $_SERVER['PHP_SELF'];
    $this->empty_value = '<span>&mdash;</span>';
    $this->db = $obj_db;
  }

  /**
   * @param $column
   * @param null $alias
   * @param null $callback
   * @return $this
   */
  public function addColumn($column, $alias = null, $callback = null)
  {
    if (!is_null($alias)) {
      $this->sort_column[$alias] = $alias;
      $this->sql_column .= $column . ' AS \'' . $alias . '\', ';
      $index_num = array_search($alias, array_keys($this->sort_column));
    } else {
      $this->sort_column[$column] = $column;
      $this->sql_column .= $column . ', ';
      $index_num = array_search($column, array_keys($this->sort_column));
    }

    if (!is_null($callback)) $this->modifyColumnContent($index_num, $callback);

    return $this;
  }

  /**
   * @param bool $print
   * @return string
   */
  public function create($print = true)
  {
    if ($this->sql_column == '') {
      $this->sql_column = '*';
    } else {
      $this->sql_column = substr_replace($this->sql_column, ' ', -2);
    }
    if (!empty($this->filter)) $this->setSQLCriteria(implode(' AND ', $this->filter));
    try {
      $output = parent::createDataGrid($this->db, $this->table, $this->row_to_show, $this->editable);
    } catch (Exception $e) {
      $output = $e->getMessage();
    }
    if ($print) echo $output;
    return $output;
  }

  /**
   * @param mixed $table
   * @return SimpleDatagrid
   */
  public function setTable($table)
  {
    $this->table = $table;
    return $this;
  }

  /**
   * @param int $row_to_show
   * @return SimpleDatagrid
   */
  public function setRowToShow($row_to_show)
  {
    $this->row_to_show = $row_to_show;
    return $this;
  }

  /**
   * @return SimpleDatagrid
   */
  public function isEditAble()
  {
    $this->editable = true;
    return $this;
  }

  /**
   * @return $this
   */
  public function notEditAble()
  {
    $this->editable = false;
    return $this;
  }

  public function addFilter($key, $field, $method = 'get')
  {
    $keyword = utility::filterData($key, $method, true, true, true);
    if (!$keyword) return;
    if (!is_array($field)) $field = [$field];
    $criteria = [];
    foreach ($field as $f) {
      $criteria[] = $f . " LIKE '%" . $keyword . "%'";
    }
    $this->filter[] = ' (' . implode(' OR ', $criteria) . ') ';
  }
}