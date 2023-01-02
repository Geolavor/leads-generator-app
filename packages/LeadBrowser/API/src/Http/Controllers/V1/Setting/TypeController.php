<?php

namespace LeadBrowser\API\Http\Controllers\V1\Setting;

use Illuminate\Support\Facades\Event;
use LeadBrowser\Lead\Repositories\TypeRepository;
use LeadBrowser\API\Http\Controllers\V1\Controller;
use LeadBrowser\API\Http\Resources\V1\Setting\TypeResource;

class TypeController extends Controller
{
    /**
     * Type repository instance.
     *
     * @var \LeadBrowser\Lead\Repositories\TypeRepository
     */
    protected $typeRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Lead\Repositories\TypeRepository  $typeRepository
     * @return void
     */
    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * Display a listing of the type.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = $this->allResources($this->typeRepository);

        return TypeResource::collection($types);
    }

    /**
     * Show resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $resource = $this->typeRepository->find($id);

        return new TypeResource($resource);
    }

    /**
     * Store a newly created type in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|unique:lead_types,name',
        ]);

        Event::dispatch('settings.type.create.before');

        $type = $this->typeRepository->create(request()->all());

        Event::dispatch('settings.type.create.after', $type);

        return response([
            'data'    => new TypeResource($type),
            'message' => __('admin::app.settings.types.create-success'),
        ]);
    }

    /**
     * Update the specified type in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'name' => 'required|unique:lead_types,name,' . $id,
        ]);

        Event::dispatch('settings.type.update.before', $id);

        $type = $this->typeRepository->update(request()->all(), $id);

        Event::dispatch('settings.type.update.after', $type);

        return response([
            'data'    => new TypeResource($type),
            'message' => __('admin::app.settings.types.update-success'),
        ]);
    }

    /**
     * Remove the specified type from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Event::dispatch('settings.type.delete.before', $id);

            $this->typeRepository->delete($id);

            Event::dispatch('settings.type.delete.after', $id);

            return response([
                'message' => __('admin::app.settings.types.delete-success'),
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => __('admin::app.settings.types.delete-failed'),
            ], 500);
        }
    }
}
