<?php

namespace LeadBrowser\Admin\Http\Controllers\CMS;

use LeadBrowser\Admin\DataGrids\CMS\CMSBlogDataGrid;
use LeadBrowser\CMS\Repositories\CmsBlogsRepository;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\CMS\Models\CmsBlog;

class BlogController extends Controller
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
     * @param  \LeadBrowser\CMS\Repositories\CmsBlogsRepository  $cmsBlogsRepository
     * @return void
     */
    public function __construct(protected CmsBlogsRepository $cmsBlogsRepository)
    {
        // $this->_config = request('_config');
    }

    /**
     * Loads the index blog showing the static blogs resources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(CMSBlogDataGrid::class)->toJson();
        }

        return view('admin::cms.blogs.index');
    }

    /**
     * Loads the index blog showing the static blogs resources.
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        // $collection = app(CMSBlogDataGrid::class)->toJson();
        $collection = CmsBlog::get();

        return view('admin::cms.blogs.list')->with('collection', $collection);
    }

    /**
     * To extract the blog content and load it in the respective view file
     *
     * @param  string  $urlKey
     * @return \Illuminate\View\View
     */
    public function view($urlKey)
    {
        $blog = $this->cmsBlogsRepository->findByUrlKeyOrFail($urlKey);

        return view('admin::cms.blogs.view')->with('blog', $blog);
    }

    /**
     * To create a new CMS blog.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::cms.blogs.create');
    }

    /**
     * To store a new CMS blog in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->all();

        $this->validate(request(), [
            'url_key'      => ['required', 'unique:cms_blog_translations,url_key', new \LeadBrowser\Core\Contracts\Validations\Slug],
            'blog_title'   => 'required',
            'html_content' => 'required',
            'image'        => 'nullable'
        ]);

        $currentUser = auth()->guard('user')->user();
        $data['author_id'] = $currentUser->id;

        $blog = $this->cmsBlogsRepository->create($data);

        if (request()->hasFile('image')) {
            $data['image'] = request()->file('image')->store('blogs/' . $blog->id);
        }

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'blog']));

        return redirect()->route('cms.blogs.index');
    }

    /**
     * To edit a previously created CMS blog.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $blog = $this->cmsBlogsRepository->findOrFail($id);

        return view('admin::cms.blogs.edit', compact('blog'));
    }

    /**
     * To update the previously created CMS blog in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $locale = core()->getRequestedLocaleCode();

        $this->validate(request(), [
            $locale . '.url_key'      => ['required', new \LeadBrowser\Core\Contracts\Validations\Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->cmsBlogsRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('admin::app.response.already-taken', ['name' => 'Blog']));
                }
            }],
            $locale . '.blog_title'   => 'required',
            $locale . '.html_content' => 'required',
        ]);

        $this->cmsBlogsRepository->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Blog']));

        return redirect()->route('cms.blogs.index');
    }

    /**
     * To delete the previously create CMS blog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $blog = $this->cmsBlogsRepository->findOrFail($id);

        if ($blog->delete()) {
            return response()->json(['message' => trans('admin::app.cms.blogs.delete-success')]);
        }

        return response()->json(['message' => trans('admin::app.cms.blogs.delete-failure')], 500);
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
            $blogIDs = explode(',', $data['indexes']);

            $count = 0;

            foreach ($blogIDs as $blogId) {
                $blog = $this->cmsBlogsRepository->find($blogId);

                if ($blog) {
                    $blog->delete();

                    $count++;
                }
            }

            if (count($blogIDs) == $count) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', [
                    'resource' => 'CMS Blogs',
                ]));
            } else {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.partial-action', [
                    'resource' => 'CMS Blogs',
                ]));
            }
        } else {
            session()->flash('warning', trans('admin::app.datagrid.mass-ops.no-resource'));
        }

        return redirect()->route('cms.blogs.index');
    }
}