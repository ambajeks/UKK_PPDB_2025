<x-guest-layout>
    <h2 class="text-2xl font-bold text-center mb-4 text-gray-900">Daftar Akun Baru</h2>
    <p class="text-center text-sm mb-6 text-gray-700">Isi data diri kamu untuk membuat akun</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Username -->
        <div class="mb-4">
            <x-input-label for="username" value="Username" class="text-gray-900" />
            <x-text-input id="username" type="text" name="username"
                class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900"
                :value="old('username')" required autofocus />
            <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-600" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" value="Email" class="text-gray-900" />
            <x-text-input id="email" type="email" name="email"
                class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900"
                :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- No HP -->
        <div class="mb-4">
            <x-input-label for="no_hp" value="Nomor HP" class="text-gray-900" />
            <x-text-input id="no_hp" type="text" name="no_hp"
                class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900"
                :value="old('no_hp')" 
                pattern="[0-9]{11,13}"
                maxlength="13"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                required />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" value="Password" class="text-gray-900" />
            <div class="relative">
                <input id="password" type="password" name="password"
                    value="{{ old('password') }}"
                    class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-md shadow-sm px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required />
                <button type="button" 
                    onclick="togglePasswordVisibility('password', 'password-eye')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg id="password-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-900" />
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-md shadow-sm px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required />
                <button type="button" 
                    onclick="togglePasswordVisibility('password_confirmation', 'password-confirmation-eye')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg id="password-confirmation-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <!-- Google reCAPTCHA -->
        <div class="mb-6">
            <x-input-label class="text-gray-900 mb-2">
                Verifikasi Captcha <span class="text-red-500">*</span>
            </x-input-label>
            <div class="mt-2">
                {!! NoCaptcha::display() !!}
            </div>
            @error('g-recaptcha-response')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
        </script>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                Daftar
            </x-primary-button>
        </div>
    </form>
    
    {!! NoCaptcha::renderJs() !!}
</x-guest-layout>