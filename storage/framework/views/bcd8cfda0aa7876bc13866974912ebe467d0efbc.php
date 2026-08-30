<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'NCBII Academic Information System'); ?></title>
    <link rel="stylesheet" href="<?php echo e(route('legacy.style')); ?>">
    <script src="<?php echo e(route('legacy.mock-data')); ?>" defer></script>
    <script src="<?php echo e(asset('js/portal.js')); ?>" defer></script>
</head>
<body class="<?php echo e($bodyClass ?? ''); ?>">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\CAPSTONE PROJECT\resources\views/layouts/portal.blade.php ENDPATH**/ ?>