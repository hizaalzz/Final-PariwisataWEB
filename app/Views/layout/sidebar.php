<aside class="main-sidebar">
    <section class="sidebar">
<div class="user-panel">
    <div class="pull-left image">
        <img src="<?= base_url(); ?>/images/user.png" class="img-circle" alt="Foto Profil" />
    </div>
    <div class="pull-left info">
        <p>ADMIN</p>
        <a href="<?= site_url('#'); ?>">
            <i class="fa fa-circle text-success"></i>
            Online
        </a>
    </div>
</div>
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>

    <li class="<?= ($halaman == 'kategori') ? 'active' : ''; ?>">
        <a href="<?= site_url('kategori'); ?>">
            <i class="fa fa-cubes"></i> <span>Kategori</span>
        </a>
    </li>
    <li class="<?= ($halaman == 'pariwisata') ? 'active' : ''; ?>">
        <a href="<?= site_url('pariwisata'); ?>">
            <i class="fa fa-cube"></i> <span>Pariwisata</span>
        </a>
    </li>
    <li class="<?= ($halaman == 'user') ? 'active' : ''; ?>">
        <a href="<?= site_url('user'); ?>">
            <i class="fa fa-user"></i> <span>User</span>
        </a>
    </li>
</ul>
    </section>
</aside>