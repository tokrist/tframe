<?php
/**
 * @var $this \tframe\core\View
 */

use tframe\common\components\button\Button;
use tframe\common\components\text\Text;

$this->title = 'Roles';
?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?= Button::generateClickButton('/routes-management/roles/create', 'btn-primary', 'New Role', 'fa-plus') ?>
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

$this->registerJS(<<<JS

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
        url: '/api/routes-management/roles/list',
        dataSrc:""
    },
    columns: [
        { title:"ID", data: 'id' },
        { title:"Role Name", data: 'roleName' },
        { title:"Role Icon", data: function (data) { return (!data.roleIcon ) ? '$notset' : data.roleIcon} },
        { title:"Description", data: function (data) { return (!data.description ) ? '$notset' : data.description} },
        { title:"Created at", data:  'created_at' },
        { title:"Updated at", data:  function (data) { return (!data.updated_at) ? '$notset' : data.updated_at } },
        { title:'Modify', data: function (data) { return '<a data-bs-toggle="tooltip" data-bs-placement="top"'+
        'data-bs-title="Edit" href="/routes-management/roles/manage/'+data.id+'"><i class="fa-solid fa-gear"></i></a>'
         } }
    ],
    order: [[1, 'asc']]
});

JS
);

?>