<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 14/08/2022 8:24
 * @File name           : FormBootstrapAjax.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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


class FormBootstrapAjax extends FormMaker
{
    public function printOut()
    {
        $output = '';
        $this->submit_target = 'submitExec';
        $output .= $this->startForm()."\n";

        foreach ($this->elements as $row) {
            $row['element']->element_attr .= 'class="form-control"';
            $form_element = $this->combineAttribute('class', $row['element']->out());
            $output .= <<<HTML
<div class="row mb-3 input-wrapper--{$row['element']->element_name}">
    <label for="help-{$row['element']->element_name}" class="col-sm-2 form-label">{$row['label']}</label>
    <div class="col-sm-10">
      {$form_element}
      <div id="help-{$row['element']->element_name}" class="form-text">{$row['info']}</div>
    </div>
</div>
HTML;

        }

        $output .= $this->endForm();
        $output .= '<iframe name="submitExec" class="noBlock" style="visibility: hidden; width: 100%; height: 0;"></iframe>';
        return $output;
    }

    /**
     * @param $attr
     * @param $value
     * @return string
     */
    function combineAttribute($attr, $value): string
    {
        $found = preg_match_all("/$attr=\"([^\"]+)\"/", $value, $matches);
        if ($found)
        {
            $combined = $attr . '="' . implode(' ', $matches[1]) . '"';
            $patterns = $matches[0];
            $replace = array_pad(array($combined), count($matches[0]), '');
            $value = str_replace($patterns, $replace, $value);
        }
        return $value;
    }
}