<?php

namespace LeadBrowser\Admin\Http\Controllers\CMS;

use LeadBrowser\Admin\DataGrids\CMS\CMSPageDataGrid;
use LeadBrowser\CMS\Repositories\CmsPagesRepository;
use LeadBrowser\Admin\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * To hold the request variables from route file.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \LeadBrowser\CMS\Repositories\CmsPagesRepository  $cmsPagesRepository
     * @return void
     */
    public function __construct(protected CmsPagesRepository $cmsPagesRepository)
    {
        // $this->_config = request('_config');
    }

    /**
     * Loads the index page showing the static pages resources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(CMSPageDataGrid::class)->toJson();
        }

        return view('admin::cms.pages.index');
    }

    /**
     * To extract the page content and load it in the respective view file
     *
     * @param  string  $urlKey
     * @return \Illuminate\View\View
     */
    public function view($urlKey)
    {
        $page = $this->cmsPagesRepository->findByUrlKeyOrFail($urlKey);

        return view('admin::cms.pages.view')->with('page', $page);
    }

    /**
     * To create a new CMS page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::cms.pages.create');
    }

    /**
     * To store a new CMS page in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->all();

        $this->validate(request(), [
            'url_key'      => ['required', 'unique:cms_page_translations,url_key', new \LeadBrowser\Core\Contracts\Validations\Slug],
            'page_title'   => 'required',
            'html_content' => 'required',
        ]);

        $page = $this->cmsPagesRepository->create(request()->all());

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'page']));

        return redirect()->route('cms.pages.index');
    }

    /**
     * To edit a previously created CMS page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page = $this->cmsPagesRepository->findOrFail($id);

        return view('admin::cms.pages.edit', compact('page'));
    }

    /**
     * To update the previously created CMS page in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $locale = core()->getRequestedLocaleCode();

        $this->validate(request(), [
            $locale . '.url_key'      => ['required', new \LeadBrowser\Core\Contracts\Validations\Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->cmsPagesRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('admin::app.response.already-taken', ['name' => 'Page']));
                }
            }],
            $locale . '.page_title'   => 'required',
            $locale . '.html_content' => 'required'
        ]);

        $this->cmsPagesRepository->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Page']));

        return redirect()->route('cms.pages.index');
    }

    /**
     * To delete the previously create CMS page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $page = $this->cmsPagesRepository->findOrFail($id);

        if ($page->delete()) {
            return response()->json(['message' => trans('admin::app.cms.pages.delete-success')]);
        }

        return response()->json(['message' => trans('admin::app.cms.pages.delete-failure')], 500);
    }

    /**
     * To mass delete the CMS resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDelete()
    {
        $data = request()->all();

        if ($data['indexes']) {
            $pageIDs = explode(',', $data['indexes']);

            $count = 0;

            foreach ($pageIDs as $pageId) {
                $page = $this->cmsPagesRepository->find($pageId);

                if ($page) {
                    $page->delete();

                    $count++;
                }
            }

            if (count($pageIDs) == $count) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', [
                    'resource' => 'CMS Pages',
                ]));
            } else {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.partial-action', [
                    'resource' => 'CMS Pages',
                ]));
            }
        } else {
            session()->flash('warning', trans('admin::app.datagrid.mass-ops.no-resource'));
        }

        return redirect()->route('cms.pages.index');
    }
}
