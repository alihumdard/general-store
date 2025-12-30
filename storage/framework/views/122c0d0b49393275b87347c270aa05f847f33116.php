<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RetailPro POS - Store Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Modern Retail Palette: Slate & Amber
                        'store-primary': '#0f172a',    /* Dark Slate / Navy */
                        'store-accent': '#f59e0b',     /* Amber/Gold for highlights */
                        'store-bg': '#f8fafc',         /* Light Slate Background */
                        'store-card': '#ffffff',
                        'store-text-main': '#1e293b',
                    },
                    boxShadow: {
                        '3xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Geometric Retail Pattern */
       .store-background {
            background-color: #f1f5f9;
            background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        
        @keyframes pulsing {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        .whatsapp-pulse {
            animation: pulsing 1.5s infinite;
        }

        .input-focus:focus {
             box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
             border-color: #f59e0b;
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
</head>

<body class="store-background min-h-screen flex items-center justify-center font-sans p-4">

    <div class="flex flex-col md:flex-row w-full max-w-6xl bg-store-card rounded-3xl shadow-3xl overflow-hidden transition-all duration-500">
        
        <div class="hidden md:flex md:w-5/12 sidebar-gradient p-12 flex-col items-center justify-center text-white text-center">
            
            <div class="flex flex-col items-center mb-6">
                <i class="fas fa-shopping-bag text-7xl text-store-accent mb-4 animate-pulse"></i>
                <h1 class="text-5xl font-black tracking-tighter uppercase italic">RetailPro</h1>
                <div class="h-1 w-20 bg-store-accent mt-2 rounded-full"></div>
            </div>

            <p class="text-xl font-medium mb-10 opacity-80 italic">
                Cloud-Based Inventory & Sales Management for Modern Stores.
            </p>
            
            <div class="w-full space-y-6 text-left border-t border-slate-700 pt-8">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center mr-4 border border-slate-700">
                        <i class="fas fa-boxes-stacked text-store-accent"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold block leading-none">Smart Inventory</span>
                        <span class="text-xs opacity-60">Automated stock alerts & procurement.</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center mr-4 border border-slate-700">
                        <i class="fas fa-barcode text-store-accent"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold block leading-none">Swift POS Terminal</span>
                        <span class="text-xs opacity-60">Scan, bag, and bill in seconds.</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center mr-4 border border-slate-700">
                        <i class="fas fa-chart-pie text-store-accent"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold block leading-none">Profit Analytics</span>
                        <span class="text-xs opacity-60">Daily sales reports & margin tracking.</span>
                    </div>
                </div>
            </div>
            
            <p class="mt-12 text-[10px] uppercase tracking-widest opacity-40 font-bold">Version 4.0 Standard Edition</p>

        </div>

        <div class="w-full md:w-7/12 p-8 sm:p-14 lg:p-20 flex flex-col justify-center">
            
            <div class="flex items-center justify-center md:hidden mb-8">
               <i class="fas fa-shopping-bag text-4xl text-store-accent mr-3"></i>
               <h1 class="text-3xl font-black text-store-primary tracking-tighter">RetailPro</h1>
            </div>

            <h2 class="text-4xl font-black text-store-primary mb-2 text-center md:text-left tracking-tight">
                Staff Terminal
            </h2>
            <p class="text-center md:text-left text-slate-500 mb-10 font-medium">
                Please authorize to access the point-of-sale system.
            </p>

            <form id="loginForm" method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="mb-6">
                    <label for="email" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                        Staff Email Address
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="manager@store.com"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700"
                            required
                            value="<?php echo e(old('email')); ?>"
                        />
                         <i class="fas fa-user-tie absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                        Security Pin / Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700"
                            required
                        />
                        <i class="fas fa-shield-halved absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex items-center justify-between mb-8 px-1">
                    <label class="flex items-center text-sm text-slate-600 cursor-pointer font-bold">
                        <input type="checkbox" name="remember" class="mr-3 w-4 h-4 rounded border-slate-300 text-store-accent focus:ring-store-accent" />
                        Remember Terminal
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-bold text-store-accent hover:text-amber-600 transition duration-200 underline decoration-2 underline-offset-4">
                        Forgot Key?
                    </a>
                </div>

                <?php if(session('error')): ?>
                <div class="mb-6 p-4 bg-red-50 text-xs font-bold text-center text-red-700 rounded-2xl border border-red-100 flex items-center justify-center uppercase tracking-tighter" role="alert">
                    <i class="fas fa-triangle-exclamation mr-2 text-base"></i> <?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>

                <button type="submit" class="w-full bg-store-primary hover:bg-slate-800 text-white font-black text-lg py-4 rounded-2xl shadow-xl hover:shadow-store-accent/20 transition duration-300 transform active:scale-[0.98] flex items-center justify-center group">
                    <span class="mr-2">Open Terminal</span>
                    <i class="fas fa-arrow-right text-store-accent group-hover:translate-x-2 transition-transform"></i>
                </button>

                <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-400 font-medium">
                        Need technical assistance? 
                        <a href="#" class="text-store-primary hover:text-store-accent font-black transition duration-200 ml-1">
                            System Admin
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="fixed bottom-8 right-8 z-50">
        <a target="_blank" href="https://wa.me/917845667204" title="Contact Support" class="block group">
            <div class="bg-store-primary text-white w-14 h-14 text-2xl rounded-2xl flex items-center justify-center shadow-2xl whatsapp-pulse transition duration-300 group-hover:bg-store-accent group-hover:-translate-y-2">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="absolute right-full mr-4 top-1/2 -translate-y-1/2 bg-white px-3 py-1 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                <span class="text-xs font-black text-store-primary uppercase tracking-tighter">Live Help Desk</span>
            </div>
        </a>
    </div>

</body>
</html><?php /**PATH E:\code_2\general-store\resources\views/pages/auth/login.blade.php ENDPATH**/ ?>