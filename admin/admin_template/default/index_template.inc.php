<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?? 'SLiMS-X' ?>></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>

    <script type="text/javascript" src="<?php echo JWB; ?>jquery.js"></script>
    <script type="text/javascript" src="<?php echo JWB; ?>updater.js"></script>
    <script type="text/javascript" src="<?php echo JWB; ?>gui.js?"></script>
    <script type="text/javascript" src="<?php echo JWB; ?>form.js"></script>

    <style>
        .subMenuHeader {
            font-weight: bold;
            padding: 0 .5rem;
            margin-top: 1rem;
            margin-bottom: .5rem;
            text-transform: lowercase;
            color: rgb(100 116 139);
        }

        .subMenuHeader:first-letter {
            text-transform: capitalize;
        }

        .subMenuItem {
            padding: .5rem;
            color: rgb(148 163 184);
        }

        .subMenuItem.curModuleLink {
            --tw-text-opacity: 1;
            --tw-bg-opacity: 1;
            border-radius: 0.375rem;
            color: rgb(203 213 225 / var(--tw-text-opacity));
            background-color: rgb(71 85 105 / var(--tw-bg-opacity));
        }

        .subMenuItem:hover {
            --tw-text-opacity: 1;
            color: rgb(226 232 240 / var(--tw-text-opacity));
        }
    </style>
</head>
<body>
<div class="flex h-screen">
    <div class="px-3 py-4 bg-slate-800">
        <ul class="flex flex-col">
            <li class="w-12 h-12 mb-2 flex justify-center items-center rounded-full bg-yellow-600"></li>
            <li class="h-0 mb-3 w-full border-b border-slate-700"></li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center rounded-full bg-yellow-500"></li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center rounded-full bg-yellow-400"></li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center rounded-full bg-yellow-200"></li>
        </ul>
    </div>
    <div class="flex pt-4 bg-slate-800 flex-1">
        <div class="w-64 bg-slate-700 rounded-tl-md">
            <div class="py-3 px-3 border-b border-slate-600 text-slate-100">
                <strong>Waris Agung Widodo</strong>
            </div>
            <nav id="sidepan" class="flex flex-col px-2 text-sm">
                <?= $sub_menu ?? ''; ?>
            </nav>
        </div>
        <div class="bg-slate-200 flex-1">
            <div class="py-3 px-3 border-b border-slate-400 text-slate-700">
                <strong>Dashboard</strong>
            </div>
            <main id="mainContent">
                <?= $main_content ?? '' ?>
            </main>
        </div>
    </div>
</div>

<!-- fake submit iframe for search form, DONT REMOVE THIS! -->
<iframe name="blindSubmit" style="display: none; visibility: hidden; width: 0; height: 0;"></iframe>
<!-- <iframe name="blindSubmit" style="visibility: visible; width: 100%; height: 300px;"></iframe> -->
<!-- fake submit iframe -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
