<div class="switch-view-container">
    @if (request('view_type'))
        <a href="{{ route('activities.index') }}" class="icon-container">
            <i class="bi bi-table"></i>
        </a>

        <a  class="icon-container active">
            <i class="bi bi-kanban"></i>
        </a>
    @else
        <a class="icon-container active">
            <i class="bi bi-table"></i>
        </a>

        <a href="{{ route('activities.index', ['view_type' => 'calendar']) }}" class="icon-container">
            <i class="icon bi-calendar"></i>
        </a>
    @endif
</div>