<div class="switch-pipeline-container">
    <div class="form-group">
        @php
            $pipelineRepository = app('LeadBrowser\Lead\Repositories\PipelineRepository');

            if (! $pipelineId = request('pipeline_id')) {
                $pipelineId = $pipelineRepository->getDefaultPipeline()->id;
            }
        @endphp

        <select class="control" onchange="window.location.href = this.value">
            @foreach (app('LeadBrowser\Lead\Repositories\PipelineRepository')->all() as $pipeline)
                @php
                    if ($viewType = request('view_type')) {
                        $url = route('leads.index', [
                            'pipeline_id' => $pipeline->id,
                            'view_type'   => $viewType
                        ]);
                    } else {
                        $url = route('leads.index', ['pipeline_id' => $pipeline->id]);
                    }
                @endphp

                <option value="{{ $url }}" {{ $pipelineId == $pipeline->id ? 'selected' : '' }}>
                    {{ $pipeline->name }}
                </option> 
            @endforeach
        </select>
    </div>
</div>

<div class="switch-view-container">
    @if (request('view_type'))
        <a href="{{ route('leads.index') }}" class="icon-container">
            <i class="bi bi-kanban"></i>
        </a>

        <a class="icon-container active">
            <i class="bi bi-table"></i>
        </a>
    @else
        <a  class="icon-container active">
            <i class="bi bi-kanban"></i>
        </a>

        <a href="{{ route('leads.index', ['view_type' => 'table']) }}" class="icon-container">
            <i class="bi bi-table"></i>
        </a>
    @endif
</div>