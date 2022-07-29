<?php
/**
 * simbio_form_element
 * Collection of Form Element Class
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

namespace SLiMS\Simbio\GUI\Form\Elements;


use Simbio\GUI\Form\FormElement;

class Radio extends FormElement
{

  /**
   * Below method must be inherited
   *
   * @return  string
   */
  public function out()
  {
    // check for $this->element_options param
    if (!is_array($this->element_options)) {
      return 'The third argument must be an array';
    }

    $_buffer = '';

    // number of element in each column
    if (count($this->element_options) > 10) {
      $_elmnt_each_column = 4;
    } else {
      $_elmnt_each_column = 2;
    }

    $_helptext = '';

    if ($this->element_helptext) {
      $_helptext .= ' title="'.$this->element_helptext.'"';
    }

    // chunk the array into pieces of array
    $_chunked_array = array_chunk($this->element_options, $_elmnt_each_column, true);

    $_buffer .= '<table '.$_helptext.'>'."\n";
    $_buffer .= '<tr>'."\n";
    foreach ($_chunked_array as $_chunk) {
      $_buffer .= '<td valign="top">';
      foreach ($_chunk as $_radio) {
        if ($_radio[0] == $this->element_value) {
          $_buffer .= '<div><input type="radio" name="'.$this->element_name.'" id="'.$this->element_name.'"'
            .' value="'.$_radio[0].'" style="border: 0;" checked />'
            .' '.$_radio[1]."</div>\n";
        } else {
          $_buffer .= '<div><input type="radio" name="'.$this->element_name.'" id="'.$this->element_name.'"'
            .' value="'.$_radio[0].'" style="border: 0;" />'
            .' '.$_radio[1]."</div>\n";
        }
      }
      $_buffer .= '</td>';
    }
    $_buffer .= '</tr>'."\n";
    $_buffer .= '</table>'."\n";

    return $_buffer;
  }
}
