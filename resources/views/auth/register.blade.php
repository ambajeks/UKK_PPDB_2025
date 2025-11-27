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
                :value="old('no_hp')" required />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" value="Password" class="text-gray-900" />
            <x-text-input id="password" type="password" name="password"
                class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-900" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

       <div class="flex items-center justify-between mt-4">
    <a class="underline text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300" href="{{ route('login') }}">
        Sudah punya akun?
    </a>

    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
        Daftar
    </x-primary-button>
</div>
    </form>
</x-guest-layout>