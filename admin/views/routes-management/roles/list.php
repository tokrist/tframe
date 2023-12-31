<?php
/**
 * @var $this \tframe\core\View
 */

use tframe\common\components\button\Button;
use tframe\common\components\text\Text;
use tframe\common\models\Users;
use tframe\core\Application;

/** @var \tframe\common\models\Users $sessionUser */
$sessionUser = Users::findOne([Users::primaryKey() => Application::$app->session->get('sessionUser')]);

$this->title = Application::t('general','Roles');
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/routes-management/roles/create', 'btn-primary', Application::t('general','New Role'), 'fa-plus') ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-striped dataTable dtr-inline" id="dataTable">

                    </table>
                </div>
            </div>
        </div>
    </div>

<?php

$notset = Text::notSetText();
$token = $sessionUser->token;
$apiroute = Application::$URL['API'];
$canManage = Users::canRoute($sessionUser, '@admin/routes-management/roles/manage/0') ? 'true' : 'false';
$canDelete = Users::canRoute($sessionUser, '@admin/routes-management/roles/delete/0') ? 'true' : 'false';
$edit = Application::t('general', 'Edit');
$delete = Application::t('general', 'Delete');

$this->registerJS(<<<JS

function getButtons(data) {
    let manage = '';
    let del = '';
    if(!$canManage) {
        manage = 'disabled';
    }
    if(!$canDelete || data.id === 1) {
        del = 'disabled';
    }
    let buttons = '<div class="btn-group btn-group-sm" role="group">' +
                    '<a class="btn btn-primary '+manage+'" data-bs-toggle="tooltip" data-bs-title="$edit"'+
                        'href="/routes-management/roles/manage/'+data.id+'">' +
                            '<i class="fa-solid fa-gear"></i>' +
                    '</a>' +
                    '<a class="btn btn-danger '+del+'" data-bs-toggle="tooltip" data-bs-title="$delete"'+
                        'href="/routes-management/roles/delete/'+data.id+'">' +
                            '<i class="fa-solid fa-trash"></i>' +
                    '</a>' +
                   '</div>';
    return buttons;
}

$("#dataTable").DataTable({
    "paging": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "responsive": true,
    "dom": "QB<\"row justify-content-between mt-3\"<\"col-auto\"l><\"col-auto\"f>>rtip",
    "buttons": [
        "copyHtml5", "excelHtml5", "pdfHtml5", "print"
    ],
    "processing": true,
    ajax: {
        url: '$apiroute/routes-management/roles/list',
        dataSrc:"",
        type: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer $token");
        }
    },
    columns: [
        { title:"ID", data: 'id' },
        { title:"Role Name", data: 'roleName' },
        { title:"Role Icon", data: function (data) { return (!data.roleIcon ) ? '$notset' : data.roleIcon} },
        { title:"Description", data: function (data) { return (!data.description ) ? '$notset' : data.description} },
        { title:"Created at", data:  'created_at' },
        { title:"Updated at", data:  function (data) { return (!data.updated_at) ? '$notset' : data.updated_at } },
        { title:'Modify', data: function (data) { return getButtons(data)} }
    ],
    order: [[1, 'asc']],
    drawCallback: function () {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    }
});

JS
);

?>