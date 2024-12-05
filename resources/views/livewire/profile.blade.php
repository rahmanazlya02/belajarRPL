<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Edit Profil</h2>

    <!-- Pesan Sukses -->
    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-medium">
            {{ session('message') }}
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="save">
        <!-- Nama -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nama</label>
            <input type="text" id="name" wire:model.defer="name" class="w-full border-gray-300 rounded-lg shadow-sm" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium">Email</label>
            <input type="email" id="email" wire:model.defer="email" class="w-full border-gray-300 rounded-lg shadow-sm" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Gender -->
        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Jenis Kelamin</label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" wire:model="gender" value="Laki-laki" class="mr-2" />
                    Laki-laki
                </label>
                <label class="flex items-center">
                    <input type="radio" wire:model="gender" value="Perempuan" class="mr-2" />
                    Perempuan
                </label>
            </div>
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Nomor WhatsApp -->
        <div class="mb-4">
            <label for="whatsapp" class="block text-gray-700 font-medium">Nomor WhatsApp</label>
            <input type="text" id="whatsapp" wire:model.defer="whatsapp" class="w-full border-gray-300 rounded-lg shadow-sm" />
            @error('whatsapp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- New Password -->
        <div class="mb-4">
            <label for="new_password" class="block text-gray-700 font-medium">New Password</label>
            <input type="password" id="new_password" wire:model.defer="new_password" class="w-full border-gray-300 rounded-lg shadow-sm" />
            @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm New Password -->
        <div class="mb-4">
            <label for="confirm_new_password" class="block text-gray-700 font-medium">Confirm New Password</label>
            <input type="password" id="confirm_new_password" wire:model.defer="confirm_new_password" class="w-full border-gray-300 rounded-lg shadow-sm" />
            @error('confirm_new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Button Submit -->
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Simpan</button>
    </form>
</div>
