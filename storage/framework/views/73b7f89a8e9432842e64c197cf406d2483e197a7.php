  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-absolute-top navbar-light navbar-show-hide">

    <div class="container">
      <nav class="js-mega-menu navbar-nav-wrap hs-menu-initialized hs-menu-horizontal mt-3">
        <!-- Default Logo -->
        <a class="navbar-brand" href="<?php echo e(route('landing.home')); ?>">
            <img class="navbar-brand-logo-mini logo-mini-border" src="<?php echo e(asset('vendor/leadBrowser/admin/assets/images/logotyp-mini.svg')); ?>" alt="<?php echo e(config('app.name')); ?>"/>
        </a>
        <!-- <a class="navbar-brand" href="<?php echo e(route('landing.home')); ?>">
          <img class="navbar-brand-logo" src="<?php echo e(asset('vendor/leadBrowser/admin/assets/images/logotyp.svg')); ?>" alt="<?php echo e(config('app.name')); ?>"/>
        </a> -->
        <!-- End Default Logo -->

        <!-- Toggler -->
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
            <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
            <i class="bi-x"></i>
          </span>
        </button>
        <!-- End Toggler -->

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul id="navbarNavDropdownNav" class="navbar-nav">
          
            <li class="nav-item">
              <a class="nav-link" href="<?php echo e(route('compare.home')); ?>">Compare us</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo e(route('pricing.home')); ?>">Pricing</a>
            </li>

            <?php if(!auth()->guard('user')->user()): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo e(route('auth.login.create')); ?>"><?php echo e(__('admin::app.layouts.login')); ?></a>
            </li>
            <?php endif; ?>

            <?php if(auth()->guard('user')->user()): ?>
                <div class="dropdown">
                    <a class="dropdown-toggle navbar-dropdown-account-wrapper show" href="#" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="true" data-bs-auto-close="outside" data-bs-dropdown-animation="">
                        <div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="<?php echo e(auth()->guard('user')->user()->image_url); ?>" alt="Image Description">
                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                        </div>
                    </a>

                    <div class="dropdown-list dropdown-container dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-accountx" aria-labelledby="accountNavbarDropdown" style="width: 16rem; opacity: 1; transform: translateY(10px) translateY(-10px); transition: transform 300ms ease 0s, opacity 300ms ease 0s;" data-bs-popper="none">
                        
                        <a class="dropdown-item" href="#"><?php echo e(__('admin::app.layouts.app-version', ['version' => 'v' . config('app.version')])); ?></a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="<?php echo e(route('dashboard.index')); ?>"><?php echo e(__('admin::app.layouts.dashboard')); ?></a>
                        <a class="dropdown-item" href="<?php echo e(route('user.account.edit')); ?>"><?php echo e(__('admin::app.layouts.my-account')); ?></a>
                        <a class="dropdown-item"href="<?php echo e(route('session.destroy')); ?>"><?php echo e(__('admin::app.layouts.logout')); ?></a>
                        
                    </div>
                </div>
            <?php else: ?>
                <!-- Button -->
                <li class="nav-item">
                    <a class="btn btn-primary btn-transition" href="<?php echo e(route('auth.register.create')); ?>"><?php echo e(__('admin::app.layouts.register')); ?></a>
                </li>
                <!-- End Button -->
            <?php endif; ?>

          </ul>
        </div>
        <!-- End Collapse -->
      </nav>
    </div>
  </header>
  <!-- ========== END HEADER ========== --><?php /**PATH /Users/mariusz/Desktop/leadbrowser/app/packages/LeadBrowser/Admin/src/resources/views/layouts/nav-landing-top.blade.php ENDPATH**/ ?>