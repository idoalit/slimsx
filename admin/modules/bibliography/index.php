<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 06/08/2022 10:00
 * @File name           : index.php
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

use SLiMS\Simbio\Database\Datagrid\SimpleDatagrid;

const INDEX_AUTH = 1;

# load bootstrapper
require __DIR__ . '/../../../bootstrap.php';

if (isset($_GET['preview'])) {
    $id = (int)utility::filterData('id', 'get', true, true, true);
    if ($id > 0) {
        $biblio = \SLiMS\Models\Default\Biblio::find($id);
        include __DIR__ . '/previews/bibliography.php';
    }
    exit;
}

$datagrid = new SimpleDatagrid($dbs ?? \SLiMS\DB::getInstance('mysqli'));
$datagrid->setTable('biblio as b LEFT JOIN item as i ON b.biblio_id=i.biblio_id');
$datagrid->addColumn('b.biblio_id')
    ->addColumn('b.title', __('Title'))
    ->addColumn('b.isbn_issn', __('ISBN/ISSN'))
    ->addColumn('IF(COUNT(i.item_id)>0, COUNT(i.item_id), \'<strong class="text-danger">' . __('None') . '</strong>\')', __('Copies'))
    ->addColumn('b.last_update', __('Last Update'));
$datagrid->sql_group_by = 'b.biblio_id';
$datagrid->setRowToShow(20);
$datagrid->setPreviewUrl($_SERVER['PHP_SELF']);
$datagrid->setPreviewTitle('Bibliographic Preview');
$datagrid->create();