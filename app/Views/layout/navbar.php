<nav id="navbar-primary" class="navbar-primary" aria-label="Navbar Primary" data-nav="flex-menu">
    <ul id="menu-navbar-primary" class="nav yamm">
        <?php foreach ($item as $i) : ?>
            <?php if ($i['sub'] == 1) : ?>
                <li class="menu-item menu-item-has-children animate-dropdown dropdown">
                    <a title="<?= $i['nama']; ?>" data-toggle="dropdown" class="dropdown-toggle" href="#"><?= $i['nama']; ?>
                        <span class="caret"></span>
                    </a>
                    <?php
                    $subitem = new \App\Models\SubitemModel();
                    $subitem->where('item', $i['id']);
                    $subitem->where('status', 1);
                    $subitem->orderBy('nama', 'asc');
                    $sub = $subitem->findAll();
                    // $sub = $subitem->where('item', $i['id'])->orderBy('nama', 'asc')->findAll();
                    ?>
                    <ul role="menu" class="dropdown-menu">
                        <?php foreach ($sub as $s) : ?>
                            <li class="menu-item animate-dropdown">
                                <a title="<?= $s['nama']; ?>" href="<?= base_url('produk') . '/' . $s['id'] ?>"><?= $s['nama']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else : ?>
                <li class="menu-item animate-dropdown">
                    <a title="<?= $i['nama']; ?>" href="<?= base_url('produk') . '/' . $s['id'] ?>"><?= $i['nama']; ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <li class="techmarket-flex-more-menu-item dropdown">
            <a title="..." href="#" data-toggle="dropdown" class="dropdown-toggle">...</a>
            <ul class="overflow-items dropdown-menu"></ul>
        </li>
    </ul>
</nav>