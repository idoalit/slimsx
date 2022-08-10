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
use SLiMS\Models\Default\LoanHistory;
use SLiMS\Simbio\Database\Datagrid\SimpleDatagrid;

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
            $logs[date('Ymd', $strTime)]['message'][date('His', $strTime)][] = '<strong>'.$log->realname.'</strong> :: ' . $log->additional_information;
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
            function typeIcon($mime_type) {
                switch ($mime_type) {
                    case 'application/pdf':
                        return 'bi-filetype-pdf';
                    case 'text/uri-list':
                        return 'bi-link-45deg';
                    case 'application/msword':
                        return 'bi-filetype-doc';
                    case 'application/json':
                        return 'bi-filetype-json';
                    case 'application/vnd.ms-excel':
                        return 'bi-filetype-xls';
                    case 'application/vnd.ms-powerpoint':
                        return 'bi-filetype-ppt';
                    case 'audio/mpeg':
                        return 'bi-filetype-mp3';
                    case 'video/mp4':
                        return 'bi-filetype-mp4';
                    case 'text/plain':
                        return 'bi-filetype-txt';
                    default:
                        return 'bi-paperclip';
                }
            }
        }
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
if (isset($_GET['search']) && isset($_GET['keywords']) && $_GET['keywords'] !== '') {
    $datagrid->addFilter('keywords', 'title');
}
$datagrid->create();