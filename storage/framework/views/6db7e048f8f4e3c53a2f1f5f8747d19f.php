<?php $__env->startComponent('mail::message'); ?>
# Verify Your Email Address

Please click the button below to verify your email address.

<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
Verify Email Address
<?php echo $__env->renderComponent(); ?>

If you did not create an account, no further action is required.

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views\emails\verify-email.blade.php ENDPATH**/ ?>