<section>
    <div class="form-section-header">
        <div class="form-section-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div class="form-section-title">
            <h2>Perbarui Password</h2>
            <p>Pastikan akun Anda menggunakan password yang aman dan unik untuk menghindari akses tidak sah.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />
        </div>

        <div class="form-group">
            <label for="update_password_password">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" placeholder="Minimal 8 karakter">
            <x-input-error :messages="$errors->updatePassword->get('password')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" placeholder="Masukkan kembali password baru">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 13.5px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)"
                     style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 8px;">
                     <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                     </svg>
                     Password diperbarui
                </div>
            @endif
        </div>
    </form>
</section>
