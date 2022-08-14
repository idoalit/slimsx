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

use SLiMS\Models\Default\BiblioLog;
use SLiMS\Models\Default\Gmd;
use SLiMS\Models\Default\LoanHistory;
use SLiMS\Simbio\Database\Datagrid\SimpleDatagrid;
use SLiMS\Simbio\GUI\Form\FormBootstrapAjax;

const INDEX_AUTH = 1;

# load bootstrapper
require __DIR__ . '/../../../bootstrap.php';

if (isset($_GET['preview'])) {
    $id = (int)utility::filterData('id', 'get', true, true, true);
    if ($id > 0) {
        $biblio = \SLiMS\Models\Default\Biblio::find($id);
        $logs = [];
        BiblioLog::where('biblio_id', $biblio->biblio_id)->orderBy('date', 'desc')->get()->each(function ($log) use (&$logs) {
            $strTime = (int)strtotime($log->date);
            $logs[date('Ymd', $strTime)]['date'] = date('F j, Y', $strTime);
            $logs[date('Ymd', $strTime)]['message'][date('His', $strTime)][] = '<strong>' . $log->realname . '</strong> :: ' . $log->additional_information;
        });
        LoanHistory::where('biblio_id', $biblio->biblio_id)->orderBy('loan_date', 'desc')->get()->each(function ($log) use (&$logs) {
            $strTime = (int)strtotime($log->loan_date);
            $logs[date('Ymd', $strTime)]['date'] = date('F j, Y', $strTime);
            $logs[date('Ymd', $strTime)]['message'][date('His', $strTime)][] = sprintf('<strong>%s</strong> borrowed this book, with the copy number <code>%s</code>.', $log->member_name, $log->item_code);
            if ($log->return_date) {
                $strTime = (int)strtotime($log->return_date);
                $logs[date('Ymd', $strTime)]['date'] = date('F j, Y', $strTime);
                $logs[date('Ymd', $strTime)]['message'][date('His', $strTime)][] = sprintf('<strong>%s</strong> returned this book, with the copy number <code>%s</code>.', $log->member_name, $log->item_code);
            }
        });
        krsort($logs);
        if (!function_exists('typeIcon')) {
            function typeIcon($mime_type): string
            {
                return match ($mime_type) {
                    'application/pdf' => 'bi-filetype-pdf',
                    'text/uri-list' => 'bi-link-45deg',
                    'application/msword' => 'bi-filetype-doc',
                    'application/json' => 'bi-filetype-json',
                    'application/vnd.ms-excel' => 'bi-filetype-xls',
                    'application/vnd.ms-powerpoint' => 'bi-filetype-ppt',
                    'audio/mpeg' => 'bi-filetype-mp3',
                    'video/mp4' => 'bi-filetype-mp4',
                    'text/plain' => 'bi-filetype-txt',
                    default => 'bi-paperclip',
                };
            }
        }
        include __DIR__ . '/previews/bibliography.php';
    }
    exit;
}

if (isset($_POST['detail']) || (isset($_GET['action']) && $_GET['action'] == 'detail')) {
    $biblio = new \SLiMS\Models\Default\Biblio;
    if (isset($_POST['itemID'])) $biblio = \SLiMS\Models\Default\Biblio::find(utility::filterData('itemID', 'post', true, true, true));

    $form = new FormBootstrapAjax('mainForm', $_SERVER['PHP_SELF']);
    $form->addTextField('textarea', 'title', __('Title'), $biblio->title, 'rows="1"',
        __('Main title of collection. Separate child title with colon and parallel title with equal (=) sign.'));
    $form->addTextField('text', 'sor', __('Statement of Responsibility'), $biblio->sor, 'style="width: 50%;"',
        __('Main source of information to show who has written, composed, illustrated, or in other ways contributed to the existence of the item.'));
    $form->addTextField('text', 'edition', __('Edition'), $biblio->edition, 'style="width: 50%;"',
        __('A version of publication having substantial changes or additions.'));
    $form->addTextField('textarea', 'specDetailInfo', __('Specific Detail Info'), $biblio->spec_detail_info, 'rows="2"',
        __('explain more details about an item e.g. scale within a map, running time in a movie dvd.'));
    $gmd_options = Gmd::all(['gmd_id', 'gmd_name'])->map(fn($g) => [$g->gmd_id, $g->gmd_name])->toArray();
    $form->addSelectList('gmdID', __('GMD'), $gmd_options, $biblio->gmd_id, '',
        __('General material designation. The physical form of publication.'));
    echo $form->printOut();

} else {
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
    if (isset($_GET['search']) && isset($_GET['keywords']) && $_GET['keywords'] !== '') {
        $datagrid->addFilter('keywords', 'title');
    }
    $datagrid->create();
}
