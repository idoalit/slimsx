<?php
/**
 * simbio_table class
 * Class for creating HTML table
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 * Modified by Waris Agung Widodo (ido.alit@gmail.com)
 * Last Modified 2020-01-26
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace SLiMS\Simbio\GUI\Table;


class Row
{
  public $attr;
  public $fields = array();
  public $all_cell_attr;

  /**
   * Class Constructor
   *
   * @param $array_field_content
   * @param string $str_attr
   */
  public function __construct($array_field_content, $str_attr = '')
  {
    $this->attr = $str_attr;
    $this->addFields($array_field_content);
  }


  /**
   * Method to create simbio_table_field array from array
   *
   * @param array $array_field_content
   * @return void
   */
  public function addFields($array_field_content)
  {
    foreach ($array_field_content as $idx => $fld_content) {
      $_field_obj = new Field();
      $_field_obj->value = $fld_content;
      $this->fields[$idx] = $_field_obj;
    }
  }
}