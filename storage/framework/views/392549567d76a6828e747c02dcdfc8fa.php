<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo e($title ?? 'SMK ABC Library'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>" />
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body>
    <div class="app-shell">
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="mark">&#10086;</div>
                <div>
                    <div class="name">SMK ABC Library</div>
                    <div class="sub"><?php echo e(auth()->user()->isAdmin() ? 'Staff Console' : 'Student Portal'); ?></div>
                </div>
            </div>

            <div class="nav-section">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <span class="icon">&#9632;</span><span>Dashboard</span>
                    </a>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="nav-link <?php echo e(request()->routeIs('catalog.*') ? 'active' : ''); ?>">
                        <span class="icon">&#9633;</span><span>Catalog</span>
                    </a>
                    <a href="<?php echo e(route('admin.checkouts')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.checkouts') ? 'active' : ''); ?>">
                        <span class="icon">&#8635;</span><span>Active Checkouts</span>
                    </a>
                    <a href="<?php echo e(route('admin.holds')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.holds') ? 'active' : ''); ?>">
                        <span class="icon">&#9873;</span><span>Holds Queue</span>
                    </a>
                    <a href="<?php echo e(route('admin.reports')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>">
                        <span class="icon">&#8801;</span><span>Reports</span>
                    </a>
                    <a href="<?php echo e(route('admin.books.add')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.books.add') ? 'active' : ''); ?>">
                        <span class="icon">+</span><span>Add Book</span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="nav-link <?php echo e(request()->routeIs('catalog.*') ? 'active' : ''); ?>">
                        <span class="icon">&#9633;</span><span>Browse Catalog</span>
                    </a>
                    <a href="<?php echo e(route('my-books')); ?>" class="nav-link <?php echo e(request()->routeIs('my-books') ? 'active' : ''); ?>">
                        <span class="icon">&#9495;</span><span>My Books</span>
                    </a>
                    <a href="<?php echo e(route('my-holds')); ?>" class="nav-link <?php echo e(request()->routeIs('my-holds') ? 'active' : ''); ?>">
                        <span class="icon">&#9873;</span><span>My Holds</span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="sidebar-footer">
                <div class="user-chip">
                    <div class="user-avatar"><?php echo e(auth()->user()->initials()); ?></div>
                    <div class="user-meta">
                        <div class="uname"><?php echo e(auth()->user()->full_name); ?></div>
                        <div class="urole"><?php echo e(auth()->user()->role); ?></div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-link-muted">Sign out</button>
                </form>
            </div>
        </div>

        <div class="main">
            <?php echo e($slot); ?>

        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /Users/dayang/Herd/oakridge-library/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>