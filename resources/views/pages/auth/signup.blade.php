<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RetailPro POS - Merchant Registration</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Retail Theme Colors (Matching Login/Dashboard)
                        'store-primary': '#0f172a',    /* Dark Slate / Navy */
                        'store-accent': '#f59e0b',     /* Amber/Gold */
                        'store-bg': '#f8fafc',
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

        /* Focus state for inputs */
        .input-focus:focus {
             box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
             border-color: #f59e0b;
        }
        
        @keyframes pulsing {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        .whatsapp-pulse {
            animation: pulsing 1.5s infinite;
        }
    </style>
</head>

<body class="store-background font-sans flex items-center justify-center min-h-screen py-10 px-4">
    
    <div class="w-full max-w-4xl p-8 sm:p-12 bg-store-card rounded-3xl shadow-3xl transition duration-500">
        
        <div class="flex flex-col items-center mb-10">
            <div class="w-20 h-20 bg-store-primary rounded-2xl flex items-center justify-center mb-4 shadow-xl shadow-slate-200">
                <i class="fas fa-store text-4xl text-store-accent"></i>
            </div>
            <h2 class="text-4xl font-black text-store-primary text-center tracking-tight">Merchant Registration</h2>
            <p class="text-center text-slate-500 mt-2 font-medium">
                Set up your store terminal and start managing inventory today.
            </p>
        </div>

        <form id="signupForm" method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            @csrf
            
            <div>
                <label for="name" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Full Name / Owner
                </label>
                <div class="relative">
                    <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-user-tie absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('name')<p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Business Email
                </label>
                <div class="relative">
                    <input type="email" id="email" name="email" placeholder="manager@store.com" value="{{ old('email') }}" required 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-envelope absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('email')<p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="club" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Store / Business Name
                </label>
                <div class="relative">
                    <input type="text" id="club" name="club" placeholder="RetailPro Superstore" value="{{ old('club') }}"
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-shop absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('club')<p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="location" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Store Location (City)
                </label>
                <div class="relative">
                    <input type="text" id="location" name="location" placeholder="New York, USA" value="{{ old('location') }}"
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-map-location-dot absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('location')<p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Create Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="••••••••" required 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-lock absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('password')<p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Confirm Password
                </label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none input-focus transition duration-200 font-bold text-slate-700" />
                    <i class="fas fa-shield-check absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
            </div>

            <div class="col-span-full mt-2">
                <label class="block text-xs font-black text-store-primary uppercase tracking-widest mb-4 ml-1">
                    <i class="fas fa-tags mr-2 text-store-accent"></i> Business Category
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    
                    <label class="flex items-center justify-center text-center p-3 bg-slate-50 rounded-2xl border border-slate-200 hover:border-store-accent cursor-pointer transition group">
                        <input name="business_type" type="radio" value="Grocery" class="hidden peer">
                        <span class="text-xs font-bold text-slate-600 peer-checked:text-store-accent">Grocery & Mart</span>
                    </label>
                    
                    <label class="flex items-center justify-center text-center p-3 bg-slate-50 rounded-2xl border border-slate-200 hover:border-store-accent cursor-pointer transition group">
                        <input name="business_type" type="radio" value="Pharmacy" class="hidden peer">
                        <span class="text-xs font-bold text-slate-600 peer-checked:text-store-accent">Medical Store</span>
                    </label>
                    
                    <label class="flex items-center justify-center text-center p-3 bg-slate-50 rounded-2xl border border-slate-200 hover:border-store-accent cursor-pointer transition group">
                        <input name="business_type" type="radio" value="Apparel" class="hidden peer">
                        <span class="text-xs font-bold text-slate-600 peer-checked:text-store-accent">Clothing/Boutique</span>
                    </label>
                    
                    <label class="flex items-center justify-center text-center p-3 bg-slate-50 rounded-2xl border border-slate-200 hover:border-store-accent cursor-pointer transition group">
                        <input name="business_type" type="radio" value="General" class="hidden peer">
                        <span class="text-xs font-bold text-slate-600 peer-checked:text-store-accent">General Retail</span>
                    </label>
                    
                </div>
            </div>
            
            <div class="col-span-full mt-4 space-y-3">
                <label class="flex items-start text-sm text-slate-600 cursor-pointer font-medium">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1 mr-3 w-4 h-4 rounded border-slate-300 text-store-accent focus:ring-store-accent" />
                    <span>I agree to the <a href="#" class="text-store-primary font-black underline underline-offset-2">Merchant Terms</a> and POS Service Agreement.</span>
                </label>

                <label class="flex items-start text-sm text-slate-600 cursor-pointer font-medium">
                    <input type="checkbox" id="privacy" name="privacy" required class="mt-1 mr-3 w-4 h-4 rounded border-slate-300 text-store-accent focus:ring-store-accent" />
                    <span>I accept the <a href="#" class="text-store-primary font-black underline underline-offset-2">Data Privacy Policy</a> for sales records.</span>
                </label>
            </div>

            <div class="col-span-full mt-6">
                <button type="submit" 
                    class="w-full bg-store-primary hover:bg-slate-800 text-white font-black text-lg py-4 rounded-2xl shadow-xl transition duration-300 transform active:scale-[0.98] flex items-center justify-center group">
                    <i class="fas fa-rocket mr-3 text-store-accent group-hover:-translate-y-1 transition-transform"></i> Launch My Store
                </button>
            </div>

            <p class="col-span-full text-center text-sm text-slate-500 mt-6 font-medium">
                Already registered your business?
                <a href="{{ route('login') }}" class="text-store-accent font-black hover:underline underline-offset-4 ml-1 transition duration-200">Log In to Terminal</a>
            </p>
        </form>
    </div>

    <div class="fixed bottom-6 right-6 z-50">
        <a target="_blank" href="https://wa.me/917845667204" title="Contact Business Support" class="block">
            <div class="bg-store-primary text-white w-14 h-14 text-2xl rounded-2xl flex items-center justify-center shadow-2xl whatsapp-pulse transition duration-300 hover:bg-store-accent hover:-translate-y-1">
                <i class="fab fa-whatsapp"></i>
            </div>
        </a>
    </div>

</body>
</html>