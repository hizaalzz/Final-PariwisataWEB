<script>
    var urlList = "<?= site_url('user/ajaxList'); ?>";
    var urlSave = "<?= site_url('user/ajaxSave'); ?>";
    var urlEdit = "<?= site_url('user/ajaxEdit/'); ?>";
    var urlUpdate = "<?= site_url('user/ajaxUpdate'); ?>";
    var urlDelete = "<?= site_url('user/ajaxDelete/'); ?>";
    var urlStatus = "<?= site_url('user/ajaxStatus/'); ?>";
</script>
<script src="<?= base_url(); ?>/ajax/ajaxuser.js"></script>

<section class="content-header">
    <h1> <?= $title; ?> </h1>
    <ol class="breadcrumb">
        <li class="active">
            <a href ="<?= site_url('dashboard'); ?>">
                <i class="fa fa-dashboard"></i>
                Dashboard
            </a>
        </li>
        <li class="active">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <?= $title; ?>
            </a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col md-12">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah Data" onclick="show()">
                        <i class="fa fa-plus"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-default btn-sm" data-toggle="tooltip" title="Refresh Data" onclick="reload_table()">
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="box-body">
            <table class="table table-stripped table-hover" id="mytable">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 5%;">No</th>
                        <th style="text-align: center;">Nama</th>
                        <th style="text-align: center;">Username</th>
                        <th style="text-align: center;">Email</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?= $this->include('user/form'); ?>