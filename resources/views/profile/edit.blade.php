@php
    $layout = auth()->user()->role === 'user' ? 'user.layout' : 'admin.layout';
@endphp

@extends($layout)

@section('title', 'Profil Saya')
@section('header_title', 'Pengaturan Profil')

@section('content')
<!-- Custom Stylesheet for Profile Dashboard (Guarantees Premium Design without Compile Dependency) -->
<style>
    .profile-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .profile-banner-card {
        background: #ffffff;
        border: 1px solid #e8eaf0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
    .profile-banner-gradient {
        height: 120px;
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
    }
    .profile-header-info {
        padding: 48px 24px 24px;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .profile-avatar-large {
        position: absolute;
        top: -40px;
        left: 24px;
        width: 80px;
        height: 80px;
        border-radius: 16px;
        border: 4px solid #ffffff;
        background: linear-gradient(135deg, #b91c1c, #dc2626);
        color: #ffffff;
        font-weight: 800;
        font-size: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(185, 28, 28, 0.15);
    }
    .profile-name-email h1 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1d23;
        margin: 0;
    }
    .profile-name-email p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .role-badge {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fee2e2;
        padding: 2px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .profile-layout-grid {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 24px;
    }
    @media (max-width: 768px) {
        .profile-layout-grid {
            grid-template-columns: 1fr;
        }
    }
    .profile-sidebar {
        background: #ffffff;
        border: 1px solid #e8eaf0;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        height: fit-content;
    }
    .profile-sidebar-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
        width: 100%;
        transition: all 0.15s ease;
    }
    .profile-sidebar-btn:hover {
        background: #f8fafc;
        color: #1a1d23;
    }
    .profile-sidebar-btn.active {
        background: #fef2f2;
        color: #b91c1c;
    }
    .profile-content-panel {
        background: #ffffff;
        border: 1px solid #e8eaf0;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }
    /* Fixed Form wrapper to guarantee matching alignment and width */
    .profile-form-wrapper {
        max-width: 560px;
        width: 100%;
    }
    /* Form Styles */
    .form-section-header {
        border-bottom: 1px solid #f0f1f5;
        padding-bottom: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .form-section-icon {
        padding: 8px;
        background: #fef2f2;
        color: #b91c1c;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .form-section-title h2 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1d23;
        margin: 0;
    }
    .form-section-title p {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        color: #1a1d23;
        background-color: #fff;
        box-sizing: border-box; /* Ensures padding is included in width calculation */
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control:focus {
        outline: none;
        border-color: #b91c1c;
        box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15);
    }
    .form-actions {
        border-top: 1px solid #f0f1f5;
        padding-top: 20px;
        margin-top: 28px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .danger-zone-box {
        background: #fff5f5;
        border: 1px solid #ffe3e3;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
    }
    .danger-zone-icon {
        color: #e11d48;
        flex-shrink: 0;
    }
    .danger-zone-text h4 {
        font-size: 13.5px;
        font-weight: 700;
        color: #9f1239;
        margin: 0;
    }
    .danger-zone-text p {
        font-size: 12px;
        color: #be123c;
        margin-top: 4px;
        line-height: 1.5;
    }
</style>

<div class="profile-container" x-data="{ activeTab: 'info' }">
    <!-- Header Banner -->
    <div class="profile-banner-card">
        <div class="profile-banner-gradient"></div>
        <div class="profile-header-info">
            <!-- Avatar overlapping -->
            <div class="profile-avatar-large">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            
            <div class="profile-name-email">
                <h1>{{ auth()->user()->name }}</h1>
                <p>
                    <span>{{ auth()->user()->email }}</span>
                    <span class="role-badge">
                        {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : (auth()->user()->role === 'admin' ? 'Admin Kantin' : 'Pelanggan') }}
                    </span>
                </p>
            </div>
            
            <!-- Quick stats if user -->
            @if(auth()->user()->role === 'user')
                <div style="display: flex; gap: 16px; background: #f8fafc; padding: 10px 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div style="text-align: center; padding-right: 16px; border-right: 1px solid #e2e8f0;">
                        <span style="display: block; text-transform: uppercase; font-size: 10px; font-weight: 700; color: #94a3b8; letter-spacing: 0.05em;">Pemesanan</span>
                        <span style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ auth()->user()->preorders()->count() }}</span>
                    </div>
                    <div style="text-align: center;">
                        <span style="display: block; text-transform: uppercase; font-size: 10px; font-weight: 700; color: #94a3b8; letter-spacing: 0.05em;">Perangkat</span>
                        <span style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ auth()->user()->passkeys->count() }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Settings Layout -->
    <div class="profile-layout-grid">
        <!-- Left Sidebar Navigation -->
        <div class="profile-sidebar">
            <!-- Tab Button: Info -->
            <button @click="activeTab = 'info'" 
                :class="activeTab === 'info' ? 'active' : ''"
                class="profile-sidebar-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Informasi Profil
            </button>
            
            <!-- Tab Button: Password -->
            <button @click="activeTab = 'password'" 
                :class="activeTab === 'password' ? 'active' : ''"
                class="profile-sidebar-btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Keamanan Password
            </button>

            <!-- Tab Button: Danger Zone -->
            <button @click="activeTab = 'danger'" 
                :class="activeTab === 'danger' ? 'active' : ''"
                class="profile-sidebar-btn"
                style="color: #ef4444;"
                onmouseover="this.style.background='#fef2f2'"
                onmouseout="this.style.background='none'"
                :style="activeTab === 'danger' ? 'background: #fef2f2; color: #ef4444;' : ''">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Akun
            </button>
        </div>

        <!-- Right Content Panels -->
        <div>
            <!-- Panel: Profile Info -->
            <div x-show="activeTab === 'info'" 
                 x-transition:enter="transition ease-out duration-150" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 class="profile-content-panel">
                <div class="profile-form-wrapper">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Panel: Password -->
            <div x-show="activeTab === 'password'" 
                 x-transition:enter="transition ease-out duration-150" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 class="profile-content-panel" 
                 style="display: none;">
                <div class="profile-form-wrapper">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Panel: Danger Zone -->
            <div x-show="activeTab === 'danger'" 
                 x-transition:enter="transition ease-out duration-150" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 class="profile-content-panel" 
                 style="border-color: #fee2e2; display: none;">
                <div class="profile-form-wrapper">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
