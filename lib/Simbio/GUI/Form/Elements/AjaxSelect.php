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

class AjaxSelect extends FormElement
{
  /**
   * AJAX drop down special properties
   */
  public $handler_URL = 'about:blank';
  public $element_dd_list_class = 'ajaxDDlist';
  public $element_dd_list_default_text = 'SEARCHING...';
  public $additional_params = '';

  /**
   * Below method must be inherited
   *
   * @return  string
   */
  public function out()
  {
    $_buffer = '<input type="text" autocomplete="off" id="'.$this->element_name.'" name="'.$this->element_name.'" class="'.$this->element_css_class.' notAJAX" onkeyup="showDropDown(\''.$this->handler_URL.'\', \''.$this->element_name.'\', \''.$this->additional_params.'\')" value="'.$this->element_value.'" />';
    $_buffer .= '<ul class="'.$this->element_dd_list_class.'" id="'.$this->element_name.'List"><li style="padding: 2px; font-weight: bold;">'.$this->element_dd_list_default_text.'</li></ul>';

    return $_buffer;
  }
}