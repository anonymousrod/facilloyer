@forelse($notifications as $notification)
    <div class="list-group-item d-flex align-items-center
        {{ $notification->read_at ? 'bg-light' : 'bg-white shadow-sm' }}"
        style="border-left: 5px solid {{ $notification->read_at ? '#ccc' : '#007bff' }};">

        <!-- Icône -->
        <div class="me-3">
            <i class="fas fa-bell text-{{ $notification->read_at ? 'secondary' : 'primary' }} fs-4"></i>
        </div>

        <!-- Contenu -->
        <div class="flex-grow-1">
            <p class="mb-1 fw-bold text-dark">{!! $notification->data['message'] !!}</p>
            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
        </div>

        <!-- Actions -->
        <div class="d-flex align-items-center">
            @if(!$notification->read_at)
            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="me-2 mark-read-form">
                @csrf
                <button type="submit" class="btn btn-outline-success btn-sm mt-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Marquer comme lu">
                    <i class="fas fa-check"></i>
                </button>
            </form>
        @endif


            <button class="btn btn-outline-danger btn-sm delete-notification" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer" data-id="{{ $notification->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
@empty
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Aucune notification pour le moment.
    </div>
@endforelse
