@extends('admin.layout')

@section('title', 'Dashboard')

@section('body')
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="text-xl font-bold" style="color: var(--text)">Dashboard</h1>
        <p class="text-sm mt-1" style="color: var(--muted)">Quick overview of your website data</p>
    </div>

    {{-- Page Content --}}
    <div class="page-content">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
            
            <div class="stat-card">
                <div class="text-xs font-bold uppercase tracking-widest" style="color: var(--muted)">Services</div>
                <div class="text-3xl font-bold mt-2" style="color: var(--text)">{{ $stats['services'] }}</div>
            </div>

            <div class="stat-card">
                <div class="text-xs font-bold uppercase tracking-widest" style="color: var(--muted)">Projects</div>
                <div class="text-3xl font-bold mt-2" style="color: var(--text)">{{ $stats['projects'] }}</div>
            </div>

            <div class="stat-card">
                <div class="text-xs font-bold uppercase tracking-widest" style="color: var(--muted)">Technology Rings</div>
                <div class="text-3xl font-bold mt-2" style="color: var(--text)">{{ $stats['rings'] }}</div>
            </div>

            <div class="stat-card">
                <div class="text-xs font-bold uppercase tracking-widest" style="color: var(--muted)">Technologies</div>
                <div class="text-3xl font-bold mt-2" style="color: var(--text)">{{ $stats['technologies'] }}</div>
            </div>

        </div>
    </div>
@endsection