@extends('layouts.app')

@section('title', 'Tüm Bloglar - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-newspaper me-2"></i>Tüm Blog Yazıları
            </h2>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Başlık</th>
                                    <th>Yazar</th>
                                    <th>Durum</th>
                                    <th>Beğeni</th>
                                    <th>Yorum</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr id="post-{{ $post->id }}">
                                    <td>{{ Str::limit($post->title, 40) }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $post->status === 'published' ? 'Yayında' : 'Taslak' }}
                                        </span>
                                    </td>
                                    <td>{{ $post->likes_count }}</td>
                                    <td>{{ $post->comments_count }}</td>
                                    <td>{{ $post->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-warning" onclick="toggleStatus({{ $post->id }})">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deletePost({{ $post->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function toggleStatus(id) {
    fetch(`/admin/posts/${id}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deletePost(id) {
    if (confirm('Bu blogu silmek istediğinizden emin misiniz?')) {
        fetch(`/admin/posts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`post-${id}`).remove();
            }
        });
    }
}
</script>
@endsection
@endsection