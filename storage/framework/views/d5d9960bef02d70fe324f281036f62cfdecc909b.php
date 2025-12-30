<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'RetailPro'); ?></title>
    <?php echo $__env->make('includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <style>
              body {
         zoom: 90%;
      }
        /* --- High-End Central Icon Preloader --- */
        #preloader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .loader-container {
            position: relative;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Bahar ghoomnay wala ring */
        .loader-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid #f1f5f9; /* Light slate background */
            border-top: 4px solid #f59e0b; /* Amber accent */
            border-radius: 50%;
            animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        /* Center mein static icon */
        .loader-icon {
            font-size: 24px;
            color: #0f172a; /* Dark slate */
            animation: pulse-icon 1.5s ease-in-out infinite;
        }

        /* Loader Text */
        .loader-text {
            margin-top: 20px;
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #0f172a;
            font-size: 12px;
            text-align: center;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(0.9); opacity: 0.7; }
        }

        /* Content Smooth Fade-in */
        .preloading { overflow: hidden; }
        #app-content { opacity: 0; transition: opacity 0.8s ease-out; }

        /* WhatsApp pulsing animation */
        @keyframes pulsing {
            to { box-shadow: 0 0 0 20px rgba(66, 219, 135, 0); }
        }
    </style>
</head>

<body class="preloading">
    <div id="preloader">
        <div class="loader-container">
            <div class="loader-ring"></div>
            <i class="fa-solid fa-shop loader-icon"></i>
        </div>
        <div class="loader-text">RetailPro <span style="color:#f59e0b;">System</span></div>
    </div>

    <div id="app-content">
        <div class="flex min-h-screen">
            <?php echo $__env->make('includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <div class="flex-1 flex flex-col">
                <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <main class="flex-grow">
                     <?php echo $__env->yieldContent('content'); ?>
                </main>
                <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        

        <?php echo $__env->make('includes.mobile-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    
    <?php echo $__env->make('includes.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            const content = document.getElementById('app-content');
            
            preloader.style.opacity = '0';
            preloader.style.transition = 'opacity 0.5s ease';
            
            document.body.classList.remove('preloading');
            content.style.opacity = '1';
            
            setTimeout(() => {
                preloader.remove();
            }, 500); 
        });
    </script>
</body>
</html><?php /**PATH E:\code_2\general-store\resources\views/layouts/main.blade.php ENDPATH**/ ?>