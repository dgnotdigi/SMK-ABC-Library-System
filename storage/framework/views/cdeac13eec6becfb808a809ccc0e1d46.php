<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Dashboard — SMK ABC Library']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard — SMK ABC Library')]); ?>
    <div class="page-header">
        <h1>Library Dashboard</h1>
        <p>Overview of the collection and circulation</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-value"><?php echo e(number_format($summary['totalTitles'])); ?></div>
            <div class="stat-label">Titles in catalog</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e(number_format($summary['totalCopies'])); ?></div>
            <div class="stat-label">Total copies</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e(number_format($summary['totalStudents'])); ?></div>
            <div class="stat-label">Registered students</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e(number_format($summary['activeCheckouts'])); ?></div>
            <div class="stat-label">Books checked out</div>
        </div>
        <div class="stat-card alert">
            <div class="stat-value"><?php echo e(number_format($summary['overdueCount'])); ?></div>
            <div class="stat-label">Overdue right now</div>
        </div>
        <div class="stat-card gold">
            <div class="stat-value"><?php echo e(number_format($summary['waitingHolds'])); ?></div>
            <div class="stat-label">Holds waiting</div>
        </div>
    </div>

    <div class="panel">
        <h2>Quick actions</h2>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="<?php echo e(route('admin.books.add')); ?>" class="btn btn-accent">+ Add a book</a>
            <a href="<?php echo e(route('admin.checkouts')); ?>" class="btn btn-outline">View active checkouts</a>
            <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-outline">View reports</a>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH /Users/dayang/Herd/oakridge-library/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>