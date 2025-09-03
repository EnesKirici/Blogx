@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-crown me-2 text-warning"></i>Admin Dashboard
            </h2>
            
            <!-- İstatistikler -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5><i class="fas fa-users me-2"></i>Toplam Kullanıcı</h5>
                            <h2>{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5><i class="fas fa-newspaper me-2"></i>Toplam Blog</h5>
                            <h2>{{ $totalPosts }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5><i class="fas fa-comments me-2"></i>Toplam Yorum</h5>
                            <h2>{{ $totalComments }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Son Bloglar -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clock me-2"></i>Son Bloglar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Başlık</th>
                                    <th>Yazar</th>
                                    <th>Durum</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPosts as $post)
                                <tr>
                                    <td>{{ Str::limit($post->title, 50) }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $post->status === 'published' ? 'Yayında' : 'Taslak' }}
                                        </span>
                                    </td>
                                    <td>{{ $post->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection