<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RetailPro POS - Secure Verification</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Retail Theme Colors: Slate & Amber
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

<body class="store-background min-h-screen flex items-center justify-center font-sans p-4">

    <div class="w-full max-w-md p-8 sm:p-10 bg-store-card rounded-3xl shadow-3xl transition duration-500">
        
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-100 shadow-sm">
                <i class="fas fa-shield-alt text-3xl text-store-accent"></i>
            </div>
            <h2 class="text-3xl font-black text-store-primary text-center tracking-tight">Verify Terminal</h2>
            <p class="text-center text-slate-500 mt-2 font-medium">
                A 6-digit verification code has been sent to: 
                <span class="font-bold text-store-primary block mt-1 break-words italic">{{ $email }}</span>
            </p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-xs font-bold text-center text-green-700 rounded-2xl border border-green-100 flex items-center justify-center uppercase tracking-tighter" role="alert">
            <i class="fas fa-check-circle mr-2 text-base"></i> {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}">
            @csrf
            
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="mb-6">
                <label for="otp" class="block text-xs font-black text-store-primary uppercase tracking-widest mb-2 ml-1">
                    Authorization Token (OTP)
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="otp" 
                        name="otp" 
                        placeholder="000000" 
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        autocomplete="one-time-code"
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-center text-2xl font-black tracking-[0.5em] text-store-primary focus:outline-none input-focus transition duration-200" 
                        required
                    >
                    <i class="fas fa-key absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                @error('otp')
                <p class="mt-2 text-xs text-red-600 font-bold ml-1 uppercase">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" 
                class="w-full bg-store-primary hover:bg-slate-800 text-white font-black text-lg py-4 rounded-2xl shadow-xl hover:shadow-store-accent/20 transition duration-300 transform active:scale-[0.98] flex items-center justify-center group">
                <span class="mr-2">Verify Access</span>
                <i class="fas fa-arrow-right-to-bracket text-store-accent group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-100 text-center">
            <p class="text-sm text-slate-400 font-medium mb-2">Did not receive the code?</p>
            <a href="{{ route('password.request') }}" class="text-store-accent font-black hover:underline underline-offset-4 transition duration-200">
                Resend Token
            </a>
        </div>
    </div>

    <div class="fixed bottom-8 right-8 z-50">
        <a target="_blank" href="https://wa.me/917845667204" title="Contact Business Support" class="block">
            <div class="bg-store-primary text-white w-14 h-14 text-2xl rounded-2xl flex items-center justify-center shadow-2xl whatsapp-pulse transition duration-300 hover:bg-store-accent hover:-translate-y-1">
                <i class="fab fa-whatsapp"></i>
            </div>
        </a>
    </div>

</body>
</html>