<?php $__env->startComponent('mail::message'); ?>
# Reset Password

You are receiving this email because we received a password reset request for your account.

<?php $__env->startComponent('mail::button', ['url' => route('password.reset', ['token' => $token])]); ?>
Reset Password
<?php echo $__env->renderComponent(); ?>

If you did not request a password reset, no further action is required.

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\inventorymanagement\resources\views\emails\reset-password.blade.php ENDPATH**/ ?>