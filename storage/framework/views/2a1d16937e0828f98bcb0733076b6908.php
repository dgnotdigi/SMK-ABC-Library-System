<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Reports — SMK ABC Library']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Reports — SMK ABC Library')]); ?>
    <div class="page-header">
        <h1>Reports</h1>
        <p>Overdue items, popular titles, and inventory by genre</p>
    </div>

    <div class="panel">
        <h2>Overdue Books (<?php echo e($overdue->count()); ?>)</h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overdue->isEmpty()): ?>
            <p class="muted">Nothing overdue right now.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <tr>
                        <th>Title</th><th>Borrower</th><th>Grade</th><th>Due</th><th>Days Late</th><th>Est. Fine</th>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $overdue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row['title']); ?></td>
                            <td><?php echo e($row['full_name']); ?></td>
                            <td><?php echo e($row['grade'] ?? '—'); ?></td>
                            <td class="mono"><?php echo e($row['due_at']->format('M j, Y')); ?></td>
                            <td><span class="tag unavailable"><?php echo e($row['daysOverdue']); ?>d</span></td>
                            <td class="mono">$<?php echo e(number_format($row['estimatedFineCents'] / 100, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="panel">
        <h2>Most Borrowed Books</h2>
        <div class="table-wrap">
            <table class="data-table">
                <tr><th>Title</th><th>Author</th><th>Genre</th><th>Times Borrowed</th></tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $mostBorrowed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row->title); ?></td>
                        <td><?php echo e($row->author); ?></td>
                        <td><?php echo e($row->genre ?? '—'); ?></td>
                        <td><strong><?php echo e($row->borrow_count); ?></strong></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </table>
        </div>
    </div>

    <div class="panel">
        <h2>Inventory by Genre</h2>
        <div class="table-wrap">
            <table class="data-table">
                <tr><th>Genre</th><th>Titles</th><th>Total Copies</th><th>Available Now</th></tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($row->genre ?? 'Uncategorized'); ?></td>
                        <td><?php echo e($row->titles); ?></td>
                        <td><?php echo e($row->total_copies); ?></td>
                        <td><?php echo e($row->available_copies); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </table>
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
<?php /**PATH /Users/dayang/Herd/oakridge-library/resources/views/livewire/admin/reports.blade.php ENDPATH**/ ?>