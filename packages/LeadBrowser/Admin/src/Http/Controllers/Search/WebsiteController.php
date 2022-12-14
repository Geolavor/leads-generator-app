<?php

namespace LeadBrowser\Admin\Http\Controllers\Search;

use App\Imports\ContactsImport;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Search\Repositories\SearchWebsiteRepository;
use LeadBrowser\Search\Models\SearchWebsites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class WebsiteController extends Controller
{
    /**
     * SearchWebsiteRepository object
     *
     * @var \LeadBrowser\Search\Repositories\SearchWebsiteRepository
     */
    protected $searchWebsiteRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Search\Repositories\SearchWebsiteRepository  $searchWebsiteRepository
     *
     * @return void
     */
    public function __construct(SearchWebsiteRepository $searchWebsiteRepository)
    {
        $this->searchWebsiteRepository = $searchWebsiteRepository;

        request()->request->add(['entity_type' => 'search_websites']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Search\SearchWebsiteDataGrid::class)->toJson();
        }

        return view('admin::search.websites.index');
    }

    /**
     * Display a resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // $search = $this->searchWebsiteRepository->findOrFail($id);
        $search = SearchWebsites::findOrFail($id);

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $userIds = app('\LeadBrowser\User\Repositories\UserRepository')->getCurrentUserGroupsUserIds();

                if (! in_array($search->user_id, $userIds)) {
                    return redirect()->route('search.websites.index');
                }
            } else {
                if ($search->user_id != $currentUser->id) {
                    return redirect()->route('search.websites.index');
                }
            }
        }

        $search['market_size'] = $search->websites_market_size;

        return view('admin::search.websites.view', compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::search.websites.create');
    }

    public function processImport(Request $request)
    {
        $search = SearchWebsites::find($request->csv_data_file_id);
        $csv_data = json_decode($search->csv_data, true);
        
        $urls = '';

        foreach ($csv_data as $row) {
            foreach (config('extractor.websites.db_fields') as $index => $field) {

                if(isset($request->fields[$field])) {
                    if($field == 'website') {
                        $url = str_replace(',', '', $row[$field]);
                        if($url) {
                            $urls .= ($url . ',');
                        }
                    }
                }

                // if ($search->csv_header) {
                //     if($request->fields[$field]) {
                //         // $contact->$field = $row[$request->fields[$field]];
                //     }
                // } else {
                //     // $contact->$field = $row[$request->fields[$index]];

                //     if($row[$field] ?? null) {
                //         // $search[$field] = $row[$field];
                //         // $search->status_id = 1;
                //         // $search->save();
                //     }
                // }
            }
        }

        $data['urls'] = $urls;

        $search = $this->searchWebsiteRepository->create($data);

        Event::dispatch('search.create.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return redirect()->route('search.websites.view', $search->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \LeadBrowser\Attribute\Http\Requests\AttributeForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeForm $request)
    {
        Event::dispatch('search.create.before');

        $data = request()->all();

        $currentUser = auth()->guard('user')->user();
        $data['user_id'] = $currentUser->id;

        $file = request()->file('attachments');

        if($file) {

            $file = $file[0];

            $validator = Validator::make(
                [
                    'file'      => $file,
                    'extension' => strtolower($file->getClientOriginalExtension()),
                ],
                [
                    'file'          => 'required',
                    'extension'      => 'required|in:xlsx,xls,csv',
                ]
            );

            if($validator->fails()) {
                session()->flash('warning', trans('admin::app.search.wrong-file-type'));
                return redirect()->back();
            }
            
            $headings = (new HeadingRowImport)->toArray($file);
            $data = Excel::toArray(new ContactsImport, $file)[0];

            if ($request->has('header')) {
                $headings = (new HeadingRowImport)->toArray($file);
                $data = Excel::toArray(new ContactsImport, $file)[0];
            } else {
                // $data = array_map('str_getcsv', file($request->file('csv_file')->getRealPath()));
            }

            if (count($data) > 0) {
                $csv_data = array_slice($data, 0, 5);

                $csv_data_file = SearchWebsites::create([
                    'user_id' => $currentUser->id,
                    'csv_filename' => $request->file('attachments')[0]->getClientOriginalName(),
                    'csv_header' => $request->has('header'),
                    'csv_data' => json_encode($data)
                ]);
            } else {
                return redirect()->back();
            }

            return view('admin::search.websites.create', [
                'headings' => $headings ?? null,
                'csv_data' => $csv_data,
                'csv_data_file' => $csv_data_file ?? null
            ]);
        }

        $validator = Validator::make($data, [
            'urls' => 'required',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back();
        }

        $search = $this->searchWebsiteRepository->create($data);

        Event::dispatch('search.create.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return redirect()->route('search.websites.view', $search->id);
    }

    /**
     * Search search results
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->searchWebsiteRepository->findWhere([
            ['name', 'like', '%' . urldecode(request()->input('query')) . '%']
        ]);

        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->searchWebsiteRepository->findOrFail($id);

        try {
            Event::dispatch('settings.search.delete.before', $id);

            $this->searchWebsiteRepository->delete($id);

            Event::dispatch('settings.search.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.search.search')]),
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.response.destroy-failed', ['name' => trans('admin::app.search.search')]),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        foreach (request('rows') as $searchId) {
            Event::dispatch('search.delete.before', $searchId);

            $this->searchWebsiteRepository->delete($searchId);

            Event::dispatch('search.delete.after', $searchId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.search.title')]),
        ]);
    }
}
