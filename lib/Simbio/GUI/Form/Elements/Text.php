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


use SLiMS\Simbio\GUI\Form\FormElement;

class Text extends FormElement
{

  /**
   * Below method must be inherited
   *
   * @return  string
   */
  public function out()
  {
    $_buffer = '';
    if (!in_array($this->element_type, array('textarea', 'text', 'password', 'button', 'file', 'hidden', 'submit', 'button', 'reset', 'date'))) {
      return 'Unrecognized element type!';
    }
    // check if disabled
    if ($this->element_disabled) {
      $_disabled = ' disabled="disabled"';
    } else { $_disabled = ''; }
    if ($this->element_helptext) {
      $this->element_attr .= ' title="'.$this->element_helptext.'"';
    }
    // maxlength attribute
    if (!stripos($this->element_attr, 'maxlength')) {
      if ($this->element_type == 'text') {
        $this->element_attr .= ' maxlength="256"';
      } else if ($this->element_type == 'textarea') {
        $this->element_attr .= ' maxlength="'.(30*1024).'"';
      }
    }

    // sanitize name for ID
    $_elID = str_replace(array('[', ']', ' '), '', $this->element_name);

    // checking element type
    if ($this->element_type == 'textarea') {
      $_buffer .= '<textarea name="'.$this->element_name.'" id="'.$_elID.'" '.$this->element_attr.''.$_disabled.'>';
      $_buffer .= $this->element_value;
      $_buffer .= '</textarea>'."\n";
    } else if (stripos($this->element_type, 'date', 0) !== false) {
      // Modified by Eddy Subratha
      // Remove class="dateInput" because it should be defined by $this->element_attr
      // $_buffer .= '<div class="dateField"><input class="dateInput" type="'.$this->element_type.'" name="'.$this->element_name.'" id="'.$_elID.'" ';
      $_buffer .= '<div class="dateField">';
      $_buffer .= '<input type="'.$this->element_type.'" name="'.$this->element_name.'" id="'.$_elID.'" value="'.$this->element_value.'" '.$this->element_attr.''.$_disabled.' />';
      $_buffer .= '<a class="calendarLink notAJAX" onclick="javascript: dateType = \''.$this->element_type.'\'; openCalendar(\''.$_elID.'\');" title="Open Calendar"></a>';
      $_buffer .= '</div>'."\n";
    } else {
      $_buffer .= '<input type="'.$this->element_type.'" name="'.$this->element_name.'" id="'.$_elID.'" ';
      $_buffer .= 'value="'.$this->element_value.'" '.$this->element_attr.''.$_disabled.' />'."\n";
    }

    return $_buffer;
  }
}