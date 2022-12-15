<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    <title><?php echo $__env->yieldContent('page_title'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="manifest" href="<?php echo e(asset('vendor/leadBrowser/admin/assets/images/favicon/manifest.json')); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?php echo e(asset('vendor/leadBrowser/admin/assets/css/admin.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/leadBrowser/admin/assets/css/ui.css')); ?>" type="text/css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3JC7BMR1B3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-3JC7BMR1B3');

    </script>

    <?php echo $__env->yieldContent('head'); ?>

    <?php echo $__env->yieldContent('css'); ?>
    <?php echo $__env->yieldPushContent('css'); ?>

    <?php echo view_render_event('layout.head'); ?>


</head>

<body id="homeSection" class="position-relative" data-aos-easing="ease" data-aos-duration="650" data-aos-delay="0">

    <?php echo view_render_event('layout.nav-landing-top.before'); ?>


    <?php echo $__env->make('admin::layouts.nav-landing-top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo view_render_event('layout.nav-landing-top.after'); ?>


    <main id="app" role="main">
        <?php echo view_render_event('layout.content.before'); ?>


        <?php echo $__env->yieldContent('content-wrapper'); ?>

        <?php echo view_render_event('layout.content.after'); ?>

    </main>

    <?php echo view_render_event('layout.footer-landing.before'); ?>


    <?php echo $__env->make('admin::layouts.footer-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo view_render_event('layout.footer-landing.after'); ?>



</body>

</html>
<?php /**PATH /Users/mariusz/Desktop/leadbrowser/app/packages/LeadBrowser/Admin/src/resources/views/layouts/landing.blade.php ENDPATH**/ ?>