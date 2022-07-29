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

class Select extends FormElement
{

  /**
   * Below method must be inherited
   *
   * @return  string
   */
  public function out()
  {
    // check for $array_option param
    if (!is_array($this->element_options)) {
      return '<select name="'.$this->element_name.'" '.$this->element_attr.'></select>';
    }
    // check if disabled
    if ($this->element_disabled) {
      $_disabled = ' disabled="disabled"';
    } else { $_disabled = ''; }
    if ($this->element_helptext) {
      $this->element_attr .= ' title="'.$this->element_helptext.'"';
    }
    $_buffer = '<select name="'.$this->element_name.'" id="'.$this->element_name.'" '.$this->element_attr.''.$_disabled.'>'."\n";
    foreach ($this->element_options as $option) {
      if (is_string($option)) {
        // if the selected element is an array then
        // the selected option is also multiple to
        if (is_array($this->element_value)) {
          $_buffer .= '<option value="'.$option.'" '.(in_array($option, $this->element_value)?'selected':'').'>';
          $_buffer .= $option.'</option>'."\n";
        } else {
          $_buffer .= '<option value="'.$option.'" '.(($option == $this->element_value)?'selected':'').'>';
          $_buffer .= $option.'</option>'."\n";
        }
      } else {
        if (is_array($this->element_value)) {
          $_buffer .= '<option value="'.$option[0].'" '.(in_array($option[0], $this->element_value)?'selected':'').'>';
          $_buffer .= $option[1].'</option>'."\n";
        } else {
          $_buffer .= '<option value="'.$option[0].'" '.(($option[0] == $this->element_value)?'selected':'').'>';
          $_buffer .= $option[1].'</option>'."\n";
        }
      }
    }
    $_buffer .= '</select>'."\n";

    return $_buffer;
  }
}