<section>
    <div class="form-section-header">
        <div class="form-section-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div class="form-section-title">
            <h2>Informasi Profil</h2>
            <p>Perbarui nama lengkap dan alamat email akun Anda.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap">
            <x-input-error class="mt-2" :messages="$errors->get('name')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="nama@email.com">
            <x-input-error class="mt-2" :messages="$errors->get('email')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 16px; padding: 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px;">
                    <p style="font-size: 12px; color: #b45309; margin: 0;">
                        Email Anda belum terverifikasi.
                    </p>
                    <button form="send-verification" style="background: none; border: none; font-size: 12px; font-weight: 700; color: #b91c1c; text-decoration: underline; cursor: pointer; padding: 0; margin-top: 6px;">
                        Kirim ulang email verifikasi.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size: 12px; font-weight: 600; color: #059669; margin: 6px 0 0 0;">
                            Link verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 13.5px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 3000)"
                     style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 8px;">
                     <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                     </svg>
                     Berhasil disimpan
                </div>
            @endif
        </div>
    </form>
</section>
