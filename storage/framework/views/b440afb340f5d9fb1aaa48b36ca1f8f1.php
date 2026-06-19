<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Catalog — SMK ABC Library']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Catalog — SMK ABC Library')]); ?>
    <div class="page-header">
        <h1>Browse the Catalog</h1>
        <p><?php echo e(auth()->user()->isAdmin() ? 'Manage and search' : 'Search'); ?> the full collection</p>
    </div>

    <div class="toolbar">
        <input
            type="text"
            wire:model.live.debounce.350ms="search"
            placeholder="Search title, author, ISBN, or call number&hellip;"
        />

        <select wire:model.live="genre">
            <option value="">All genres</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $genreOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>"><?php echo e($g); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </select>

        <select wire:model.live="availability">
            <option value="">All availability</option>
            <option value="available">Available now</option>
            <option value="unavailable">Checked out</option>
        </select>

        <select wire:model.live="sort">
            <option value="title">Sort: Title A&ndash;Z</option>
            <option value="author">Sort: Author A&ndash;Z</option>
            <option value="newest">Sort: Newest first</option>
            <option value="oldest">Sort: Oldest first</option>
        </select>
    </div>

    <div wire:loading.delay class="spinner"></div>

    <div wire:loading.remove.delay>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($books->total() === 0): ?>
            <div class="empty-state">
                <div class="icon">&#9633;</div>
                <h3>No books found</h3>
                <p>Try a different search term or clear your filters.</p>
            </div>
        <?php else: ?>
            <p class="muted"><?php echo e(number_format($books->total())); ?> book<?php echo e($books->total() === 1 ? '' : 's'); ?> found</p>

            <div class="book-grid">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('catalog.show', $book)); ?>" class="book-card" style="display:flex; flex-direction:column;" wire:key="book-<?php echo e($book->id); ?>">
                        <div class="book-spine" style="background: <?php echo e($book->cover_color); ?>;">
                            <span class="call-no"><?php echo e($book->call_number); ?></span>
                        </div>
                        <div class="book-card-body">
                            <p class="title"><?php echo e($book->title); ?></p>
                            <p class="author"><?php echo e($book->author); ?></p>
                            <div class="meta-row">
                                <span class="tag"><?php echo e($book->genre ?? 'General'); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($book->isAvailable()): ?>
                                    <span class="tag available"><?php echo e($book->available_copies); ?> available</span>
                                <?php else: ?>
                                    <span class="tag unavailable">Checked out</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="pagination">
                <?php echo e($books->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH /Users/dayang/Herd/oakridge-library/resources/views/livewire/catalog.blade.php ENDPATH**/ ?>