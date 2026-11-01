<section style="display: flex; flex-direction: column; gap: 20px;">
    <div class="form-section-header" style="border-bottom: 1px solid #fee2e2; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; padding-bottom: 16px;">
        <div class="form-section-icon" style="background: #fff5f5; color: #e11d48; padding: 8px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div class="form-section-title">
            <h2 style="color: #e11d48; font-size: 16px; font-weight: 700; margin: 0;">Zona Bahaya: Hapus Akun</h2>
            <p style="font-size: 12px; color: #6b7280; margin-top: 2px;">Sekali Anda menghapus akun, seluruh data dan histori transaksi akan dihapus secara permanen.</p>
        </div>
    </div>

    <div class="danger-zone-box">
        <div class="danger-zone-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="danger-zone-text">
            <h4>Mohon Perhatian!</h4>
            <p>Tindakan ini tidak dapat dibatalkan. Silakan unduh riwayat pesanan atau data penting lainnya terlebih dahulu sebelum melanjutkan proses penghapusan akun.</p>
        </div>
    </div>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-primary"
        style="background: #e11d48; border-radius: 10px; padding: 10px 24px; font-size: 13.5px; align-self: flex-start;">
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 24px;">
            @csrf
            @method('delete')

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="background: #fff5f5; color: #e11d48; padding: 8px; border-radius: 8px; display: flex; align-items: center;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 style="font-size: 18px; font-weight: 700; color: #1a1d23; margin: 0;">
                    Konfirmasi Hapus Akun
                </h2>
            </div>

            <p style="font-size: 13.5px; color: #6b7280; line-height: 1.6; margin-bottom: 24px;">
                Apakah Anda yakin ingin menghapus akun Anda secara permanen? Silakan masukkan password akun Anda untuk verifikasi akhir.
            </p>

            <div style="margin-bottom: 24px;">
                <label for="password" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Password Anda</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="Masukkan password konfirmasi"
                    style="width: 100%;"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" style="color: #ef4444; font-size: 12px; margin-top: 6px; list-style: none;" />
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f0f1f5; padding-top: 16px; margin-top: 24px;">
                <button type="button" 
                    x-on:click="$dispatch('close')" 
                    class="btn btn-outline"
                    style="padding: 10px 20px; font-size: 13.5px; border-radius: 10px;">
                    Batal
                </button>

                <button type="submit" 
                    class="btn"
                    style="background: #e11d48; color: white; padding: 10px 20px; font-size: 13.5px; border-radius: 10px;">
                    Ya, Hapus Akun Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>
