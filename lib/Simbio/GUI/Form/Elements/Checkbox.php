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

class Checkbox extends FormElement
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
      return 'The radio button options list must be an array';
    } else {
      foreach ($this->element_options as $cbox) {
        // if the $cbox is not an array
        if (!is_array($cbox)) {
          return 'The radio button options list must be a 2 multi-dimensional array';
        }
      }
    }

    $_elmnt_num = count($this->element_options);
    $_row_column = 5;
    $_helptext = '';

    // check if disabled
    if ($this->element_disabled) {
      $_disabled = ' disabled="disabled"';
    } else { $_disabled = ''; }
    if ($this->element_helptext) {
      $_helptext .= ' title="'.$this->element_helptext.'"';
    }
    $_buffer = '';
    if ($_elmnt_num <= $_row_column) {
      foreach ($this->element_options as $_cbox) {
        if (is_array($this->element_value)) {
          $_buffer .= '<div '.$_helptext.'><input type="checkbox" name="'.$this->element_name.'[]"'
            .' value="'.$_cbox[0].'" style="border: 0;" '.(in_array($_cbox[0], $this->element_value)?'checked':'').$_disabled.' />'
            .' '.$_cbox[1]."</div>\n";
        } else {
          $_buffer .= '<div '.$_helptext.'><input type="checkbox" name="'.$this->element_name.'[]"'
            .' value="'.$_cbox[0].'" style="border: 0;" '.(($_cbox[0] == $this->element_value)?'checked':'').$_disabled.' />'
            .' '.$_cbox[1]."</div>\n";
        }
      }
    } else {
      $_column_array = array_chunk($this->element_options, $_row_column);
      $_buffer = '<table '.$_helptext.'>'."\n";
      $_buffer .= '<tr>'."\n";
      foreach ($_column_array as $_chunked_options) {
        $_buffer .= '<td valign="top">'."\n";
        foreach ($_chunked_options as $_cbox) {
          if (is_array($this->element_value)) {
            $_buffer .= '<div><input type="checkbox" name="'.$this->element_name.'[]"'
              .' value="'.$_cbox[0].'" style="border: 0;" '.(in_array($_cbox[0], $this->element_value)?'checked':'').$_disabled.' />'
              .' '.$_cbox[1]."</div>\n";
          } else {
            $_buffer .= '<div><input type="checkbox" name="'.$this->element_name.'[]"'
              .' value="'.$_cbox[0].'" style="border: 0;" '.(($_cbox[0] == $this->element_value)?'checked':'').$_disabled.' />'
              .' '.$_cbox[1]."</div>\n";
          }
        }
        $_buffer .= '</td>'."\n";
      }
      $_buffer .= '</tr>'."\n";
      $_buffer .= '</table>'."\n";
    }

    return $_buffer;
  }
}