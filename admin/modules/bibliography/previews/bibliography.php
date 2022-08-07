<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 06/08/2022 23:50
 * @File name           : bibliography.php
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

$biblio = $biblio ?? new \SLiMS\Models\Default\Biblio;

?>
<ul class="nav nav-tabs" id="previewTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button"
                role="tab" aria-controls="home-tab-pane" aria-selected="true">Metadata
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button"
                role="tab" aria-controls="profile-tab-pane" aria-selected="false">Items
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button"
                role="tab" aria-controls="contact-tab-pane" aria-selected="false">Attachment
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane"
                type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Timeline
        </button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active pt-2" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
         tabindex="0">
        <div class="row mb-3">
            <div class="col-4">
                <img src="<?= SWB ?>lib/minigalnano/createthumb.php?filename=images/docs/<?= $biblio->image ?? 'notfound.jpg' ?>&width=130"
                     class="img-thumbnail img-fluid" alt="Cover Image">
            </div>
            <div class="col-8">
                <h4 class="font-bold"><?= $biblio->title ?></h4>
                <div class="font-monospace mt-2">
                    <strong><?= __('By') ?>
                        .</strong> <?= implode(' | ', $biblio->authors->map(fn($a) => $a->author->author_name)->toArray()); ?>
                </div>
            </div>
        </div>
        <dl class="row">
            <dt class="col-sm-4"><?= __('Statement of Responsibility') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->sor ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Edition') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->edition ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('ISBN / ISSN') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->isbn_issn ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Specific Detail Info') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->spec_detail_info ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('GMD') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->gmd->gmd_name ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Frequency') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->frequency->frequency ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Publisher') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->publisher->publisher_name ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Publishing Year') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->publish_year ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Publishing Place') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->place->place_name ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Collation') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->collation ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Series Title') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->series_title ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Classification') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->classification ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Call Number') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->call_number ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Language') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->language->language_name ?? '-' ?></dd>

            <dt class="col-sm-4"><?= __('Abstract/Notes') ?></dt>
            <dd class="col-sm-8 mb-1"><?= $biblio->notes ?? '-' ?></dd>
        </dl>
    </div>
    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <ul class="list-group list-group-flush">
        <?php
        foreach ($biblio->items as $item) {
            $call_number = $sliced_label = preg_replace("/((?<=\w)\s+(?=\D))|((?<=\D)\s+(?=\d))/m",'</br>', $item->call_number ?? $biblio->call_number);
            $output = <<<HTML
<li class="list-group-item">
    <div class="row">
        <div class="col-4 border-end">{$call_number}</div>
        <div class="col-8">
            <div class="d-flex"><i class="bi bi-qr-code me-2"></i><span>{$item->item_code}</span></div>
            <div class="d-flex"><i class="bi bi-fonts me-2"></i><span>{$item->coll_type_id}</span></div>
            <div class="d-flex"><i class="bi bi-geo-alt me-2"></i><span>{$item->location_id}</span></div>
        </div>
    </div>
</li>
HTML;
            echo $output;
        }
        ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...
    </div>
    <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
        <ol class="relative border-l border-slate-200 dark:border-slate-500 mt-4">
            <li class="mb-10 ml-4">
                <div class="absolute w-3 h-3 bg-slate-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-slate-600 dark:bg-slate-500"></div>
                <time class="mb-1 text-sm font-normal leading-none text-slate-400 dark:text-slate-500">February 2022</time>
                <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-500">Application UI code in Tailwind CSS</h3>
                <p class="mb-4 text-base font-normal text-slate-500 dark:text-slate-400">Get access to over 20+ pages including a dashboard layout, charts, kanban board, calendar, and pre-order E-commerce &amp; Marketing pages.</p>
            </li>
        </ol>
    </div>
</div>
