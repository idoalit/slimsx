<?php
/**
 * simbio_form_maker
 * Class for creating form with element based on simbio form elements
 *
 * Copyright (C) 2017  Arie Nugraha (dicarve@gmail.com)
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

namespace SLiMS\Simbio\GUI\Form;


class FormMakerAnything
{
  public $content = '';

  public function out()
  {
    return $this->content;
  }
}