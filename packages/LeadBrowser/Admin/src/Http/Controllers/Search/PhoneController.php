<?php

namespace LeadBrowser\Admin\Http\Controllers\Search;

use App\Imports\ContactsImport;
use Illuminate\Support\Facades\Event;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Attribute\Http\Requests\AttributeForm;
use LeadBrowser\Extractor\Jobs\SearchPhones as JobsSearchPhones;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\Search\Repositories\PhoneRepository;
use LeadBrowser\Search\Models\SearchPhones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class PhoneController extends Controller
{
    /**
     * PhoneRepository object
     *
     * @var \LeadBrowser\Search\Repositories\PhoneRepository
     */
    protected $phoneRepository;

    /**
     * Create a new controller instance.
     *
     * @param \LeadBrowser\Search\Repositories\PhoneRepository  $phoneRepository
     *
     * @return void
     */
    public function __construct(PhoneRepository $phoneRepository)
    {
        $this->phoneRepository = $phoneRepository;

        request()->request->add(['entity_type' => 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(\LeadBrowser\Admin\DataGrids\Search\SearchPhoneDataGrid::class)->toJson();
        }

        return view('admin::search.phones.index');
    }

    /**
     * Display a resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // $search = $this->phoneRepository->findOrFail($id);
        $search = SearchLocations::findOrFail($id);

        $currentUser = auth()->guard('user')->user();

        if ($currentUser->view_permission != 'global') {
            if ($currentUser->view_permission == 'group') {
                $userIds = app('\LeadBrowser\User\Repositories\UserRepository')->getCurrentUserGroupsUserIds();

                if (! in_array($search->user_id, $userIds)) {
                    return redirect()->route('search.phones.index');
                }
            } else {
                if ($search->user_id != $currentUser->id) {
                    return redirect()->route('search.phones.index');
                }
            }
        }

        $search['market_size'] = $search->location_market_size;

        return view('admin::search.phones.view', compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin::search.phones.create');
    }

    public function processImport(Request $request)
    {
        $search = SearchPhones::find($request->csv_data_file_id);
        $csv_data = json_decode($search->csv_data, true);
        
        $phones = '';

        foreach ($csv_data as $row) {
            foreach (config('extractor.phones.db_fields') as $index => $field) {

                if(isset($request->fields[$field])) {
                    if($field == 'phone') {
                        $url = str_replace(',', '', $row[$field]);
                        if($url) {
                            $phones .= ($url . ',');
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

        $search->phones = $phones;
        $search->save();

        JobsSearchPhones::dispatch(
            $search,
            auth()->guard('user')->user()
        );

        Event::dispatch('search.create.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return redirect()->route('search.phones.view', $search->id);
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

                $csv_data_file = SearchPhones::create([
                    'user_id' => $currentUser->id,
                    'csv_filename' => $request->file('attachments')[0]->getClientOriginalName(),
                    'csv_header' => $request->has('header'),
                    'csv_data' => json_encode($data)
                ]);
            } else {
                return redirect()->back();
            }

            return view('admin::search.phones.create', [
                'headings' => $headings ?? null,
                'csv_data' => $csv_data,
                'csv_data_file' => $csv_data_file ?? null
            ]);
        }

        $validator = Validator::make($data, [
            'phones' => 'required',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back();
        }

        $search = $this->searchPhoneRepository->create($data);

        JobsSearchPhones::dispatch(
            $search,
            auth()->guard('user')->user()
        );

        Event::dispatch('search.create.after', $search);

        session()->flash('success', trans('admin::app.search.create-success'));

        return redirect()->route('search.phones.view', $search->id);
    }

    /**
     * Search search results
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $results = $this->phoneRepository->findWhere([
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
        $this->phoneRepository->findOrFail($id);

        try {
            Event::dispatch('settings.search.delete.before', $id);

            $this->phoneRepository->delete($id);

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

            $this->phoneRepository->delete($searchId);

            Event::dispatch('search.delete.after', $searchId);
        }

        return response()->json([
            'message' => trans('admin::app.response.destroy-success', ['name' => trans('admin::app.search.title')]),
        ]);
    }
}
