<div>
    <div class="page-header">
        <h1>My Books</h1>
        <p>Items currently checked out to you</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($checkouts->isEmpty()): ?>
        <div class="empty-state">
            <div class="icon">&#9495;</div>
            <h3>No books checked out</h3>
            <p>Browse the catalog to find your next read.</p>
        </div>
    <?php else: ?>
        <div class="book-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $checkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($isOverdue = $checkout->isOverdue()); ?>
                <div class="book-card" wire:key="checkout-<?php echo e($checkout->id); ?>">
                    <div class="book-spine" style="background: <?php echo e($checkout->book->cover_color); ?>;">
                        <span class="call-no"><?php echo e($checkout->book->call_number); ?></span>
                    </div>
                    <div class="book-card-body">
                        <p class="title"><?php echo e($checkout->book->title); ?></p>
                        <p class="author"><?php echo e($checkout->book->author); ?></p>

                        <div class="stamp-wrap">
                            <div class="stamp <?php echo e($isOverdue ? 'overdue' : ''); ?>">
                                <span class="stamp-label"><?php echo e($isOverdue ? 'Overdue Since' : 'Due Back'); ?></span>
                                <span class="stamp-date"><?php echo e($checkout->due_at->format('M j, Y')); ?></span>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($errors2[$checkout->id])): ?>
                            <div class="error-banner"><?php echo e($errors2[$checkout->id]); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($messages[$checkout->id])): ?>
                            <div class="success-banner"><?php echo e($messages[$checkout->id]); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div style="display:flex; gap:8px; margin-top:12px;">
                            <button wire:click="renew(<?php echo e($checkout->id); ?>)" class="btn btn-outline btn-sm">Renew</button>
                            <button wire:click="returnBook(<?php echo e($checkout->id); ?>)" class="btn btn-accent btn-sm">Return</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history->isNotEmpty()): ?>
        <div class="panel" style="margin-top:30px;">
            <h2>Past Returns</h2>
            <div class="table-wrap">
                <table class="data-table">
                    <tr><th>Title</th><th>Author</th><th>Returned</th><th>Fine</th></tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($h->book->title); ?></td>
                            <td><?php echo e($h->book->author); ?></td>
                            <td><?php echo e($h->returned_at->format('M j, Y')); ?></td>
                            <td><?php echo e($h->fine_cents > 0 ? '$'.number_format($h->fine_cents / 100, 2) : '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </table>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/dayang/Herd/smk-abc-library/resources/views/livewire/my-books.blade.php ENDPATH**/ ?>