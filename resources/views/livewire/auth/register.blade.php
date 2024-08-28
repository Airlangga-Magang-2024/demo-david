<!-- resources/views/livewire/auth/register.blade.php -->

<div class="flex flex-col items-center justify-center min-h-screen">
    <form wire:submit.prevent="register" class="w-full max-w-md space-y-6">
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" wire:model="name" required autofocus>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" wire:model="email" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" wire:model="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" required>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</div>
