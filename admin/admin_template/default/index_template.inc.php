<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?? 'SLiMS-X' ?>></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .subMenuHeader {
            font-weight: bold;
            padding: 0 .5rem;
            margin-top: 1rem;
            margin-bottom: .5rem;
            text-transform: lowercase;
            color: rgba(148 163 184);
        }

        .subMenuHeader:first-letter {
            text-transform: capitalize;
        }

        .subMenuItem {
            padding: .5rem .5rem .5rem 1rem;
            color: rgba(100 116 139);
            position: relative;
        }

        .subMenuItem:before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50% 50% 0 50%;
            background: #707e9b;
            background: -webkit-linear-gradient(to right, #3f4c6b, #707e9b);
            background: linear-gradient(to right, #3f4c6b, #707e9b);
            position: absolute;
            display: block;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transition: all ease-in-out .2s;
        }

        .subMenuItem.curModuleLink {
            --tw-text-opacity: 1;
            --tw-bg-opacity: 1;
            border-radius: 0.375rem;
            color: rgba(203 213 225 / var(--tw-text-opacity));
            padding: .5rem;
            background: #606c88;
            background: -webkit-linear-gradient(to right, #3f4c6b, #606c88);
            background: linear-gradient(to right, #3f4c6b, #606c88);
        }

        .subMenuItem.curModuleLink:before {
            display: none;
        }

        .subMenuItem:not(.curModuleLink):hover {
            --tw-text-opacity: 1;
            color: rgba(51 65 85 / var(--tw-text-opacity));
        }

        .subMenuItem:hover:before {
            left: 2px;
            -webkit-transform: translateY(-50%) rotate(-45deg);
            -moz-transform: translateY(-50%) rotate(-45deg);
            -ms-transform: translateY(-50%) rotate(-45deg);
        }

        #menuList {
            display: flex;
        }

        #menuList .menu {
            padding: .5rem .75rem;
        }

        #menuList .menu:hover {
            color: rgba(17 24 39);
        }

        #menuList .menu.menuCurrent {
            font-weight: bold;
            background-color: rgba(203 213 225);
            border-radius: 0.375rem;
        }

        #menuList .menu.logout {
            color: rgba(185 28 28);
            font-weight: bold;
        }

        body {
            font-size: 10pt;
            background-image: url("<?= SWB ?>images/logo.svg");
            background-repeat: no-repeat;
            background-size: 500px;
        }

        .main-container {
            background: rgba(15, 32, 39, .6);
            background: -webkit-linear-gradient(to right, rgba(44, 83, 100, .6), rgba(32, 58, 67, .6), rgba(15, 32, 39, .6));
            background: linear-gradient(to right, rgba(44, 83, 100, .6), rgba(32, 58, 67, .6), rgba(15, 32, 39, .6));
        }

        .submenu-container {
            background-color: rgba(255, 255, 255, .65);
            border: 1px solid rgba(255, 255, 255, .75);
            border-right: none;
        }

        .content-container {
            background-color: rgba(255, 255, 255, .95);
            border: 1px solid rgba(255, 255, 255, .2);
            border-left: none;
        }

        .dropdown-menu {
            background-color: rgba(255 255 255 / .75) !important;
            border-color: rgba(255 255 255 / .85) !important;
        }

        .dropdown-item {
            font-size: 14px;
        }

        .dropdown-item:hover {
            background-color: rgba(255 255 255 / .15) !important;
        }

        .item_row {
            cursor: pointer;
        }

        #datagridPreview {
            background-image: url("<?= SWB ?>images/logo.svg"), url("<?= SWB ?>images/logo.svg");
            background-repeat: no-repeat;
            background-position: left bottom, center top;
            background-size: 150%, 25%;
        }

        #datagridPreview .offcanvas-header,
        #datagridPreview .offcanvas-body {
            backdrop-filter: blur(8px);
            background-color: rgba(255 255 255 / .85);
        }

    </style>
</head>
<body>
<div class="main-container flex h-screen backdrop-blur-sm overflow-hidden">
    <div class="px-3 py-4">
        <ul class="flex flex-col">
            <li class="w-12 h-12 mb-2 flex justify-center items-center rounded-full">
                <a class="notAJAX" href="<?= AWB ?>">
                    <img src="<?= SWB ?>images/logo.svg" alt="logo" class="w-9">
                </a>
            </li>
            <li class="h-0 mb-3 w-full border-b border-slate-300"></li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=bibliography">
                    <img src="<?= AWB ?>admin_template/default/images/camera-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=circulation">
                    <img src="<?= AWB ?>admin_template/default/images/basket-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=master_file">
                    <img src="<?= AWB ?>admin_template/default/images/folder-1-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=membership">
                    <img src="<?= AWB ?>admin_template/default/images/user-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=reporting">
                    <img src="<?= AWB ?>admin_template/default/images/stat-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
            <li class="w-12 h-12 mb-3 flex justify-center items-center">
                <a class="notAJAX" href="<?= AWB ?>index.php?mod=system">
                    <img src="<?= AWB ?>admin_template/default/images/weather-svgrepo-com.svg" alt="Avatar">
                </a>
            </li>
        </ul>
    </div>
    <div class="pt-4 flex-1 overflow-x-hidden overflow-y-auto">
        <div class="flex min-h-screen">
            <div class="submenu-container shrink-0 backdrop-blur w-64 rounded-tl-md">
                <div class="relative">
                    <div class="py-3 px-3 border-b border-slate-100 text-slate-700">
                        <div class="dropdown">
                            <button class="fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                Waris Agung Widodo
                            </button>
                            <ul class="dropdown-menu backdrop-blur">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <nav class="flex flex-col px-2 text-sm menus">
                    <?= $sub_menu ?? ''; ?>
                </nav>
            </div>
            <div class="flex-1 overflow-auto content-container">
                <div class="flex justify-between py-3 px-3 border-b border-slate-200 text-slate-700">
                    <strong>&nbsp;</strong>
                    <div>

                    </div>
                </div>
                <main id="mainContent" class="p-3"></main>
            </div>
        </div>
    </div>
</div>

<!-- fake submit iframe for search form, DONT REMOVE THIS! -->
<iframe name="blindSubmit" style="display: none; visibility: hidden; width: 0; height: 0;"></iframe>
<!-- <iframe name="blindSubmit" style="visibility: visible; width: 100%; height: 300px;"></iframe> -->
<!-- fake submit iframe -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= JWB ?>slims-jquery-plugins.js"></script>
<script src="<?= JWB ?>slims.js?<?= date('YmdHis') ?>"></script>
</body>
</html>
