<?php

namespace LeadBrowser\Admin\Http\Controllers\Configuration;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use LeadBrowser\Core\Contracts\Validations\Code;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Core\Repositories\CoreConfigRepository as ConfigurationRepository;

class ConfigurationController extends Controller
{
    /**
     * ConfigurationRepository object
     *
     * @var \LeadBrowser\Core\Repositories\CoreConfigRepository
     */
    protected $configurationRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\Core\Repositories\CoreConfigRepository  $configurationRepository
     * @return void
     */
    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $slugs = $this->getDefaultConfigSlugs();

        if (count($slugs)) {
            return redirect()->route('configuration.index', $slugs);
        }

        return view('admin::configuration.index');
    }

    /**
     * Returns slugs
     *
     * @return array
     */
    public function getDefaultConfigSlugs()
    {
        if (! request()->route('slug')) {
            $firstItem = current(app('core_config')->items);

            $temp = explode('.', $firstItem['key']);

            return ['slug' => current($temp)];
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Event::dispatch('core.configuration.save.before');

        $this->configurationRepository->create(request()->all());

        Event::dispatch('core.configuration.save.after');

        session()->flash('success', trans('admin::app.configuration.save-message'));

        return redirect()->back();
    }

    /**
     * download the file for the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $path = request()->route()->parameters()['path'];

        $fileName = 'configuration/'. $path;

        $config = $this->configurationRepository->findOneByField('value', $fileName);

        return Storage::download($config['value']);
    }
}