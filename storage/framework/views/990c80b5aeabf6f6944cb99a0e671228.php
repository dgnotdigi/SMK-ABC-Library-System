<div>
    <div class="page-header">
        <h1>My Holds</h1>
        <p>Books you&rsquo;re waiting on</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errorMessage): ?>
        <div class="error-banner"><?php echo e($errorMessage); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($holds->isEmpty()): ?>
        <div class="empty-state">
            <div class="icon">&#9873;</div>
            <h3>No active holds</h3>
            <p>Place a hold from any book&rsquo;s page when all copies are checked out.</p>
        </div>
    <?php else: ?>
        <div class="book-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $holds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hold): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="book-card" wire:key="hold-<?php echo e($hold->id); ?>">
                    <div class="book-spine" style="background: <?php echo e($hold->book->cover_color); ?>;"></div>
                    <div class="book-card-body">
                        <p class="title"><?php echo e($hold->book->title); ?></p>
                        <p class="author"><?php echo e($hold->book->author); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hold->status === 'ready'): ?>
                            <span class="tag available">Ready for pickup!</span>
                        <?php else: ?>
                            <span class="tag">Waiting in queue</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button wire:click="cancel(<?php echo e($hold->id); ?>)" class="btn btn-outline btn-sm" style="margin-top:12px;">Cancel hold</button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/dayang/Herd/smk-abc-library/resources/views/livewire/my-holds.blade.php ENDPATH**/ ?>