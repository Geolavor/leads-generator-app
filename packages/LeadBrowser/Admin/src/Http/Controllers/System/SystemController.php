<?php

declare(strict_types=1);

namespace LeadBrowser\Admin\Http\Controllers\System;

use App\Classes\GIWY;
use App\Services\AIClassification;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use LeadBrowser\Admin\Http\Controllers\Controller;
use LeadBrowser\Core\Models\City;
use LeadBrowser\Core\Models\Country;
use LeadBrowser\Extractor\Services\Extractor;
use LeadBrowser\Extractor\Traits\LinkedinExtractor;
use LeadBrowser\Payment\Models\Plan;
use LeadBrowser\Extractor\Services\Crawler;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\Search\Services\SearchService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use LeadBrowser\Extractor\Classes\Browser;

class SystemController extends Controller
{
    use LinkedinExtractor;

     /**
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $browser = new Browser;
        $c = $browser->fetch('test');
        dd($c);

        ini_set('memory_limit', '1512M');
        ini_set('max_execution_time', '18880');

        // Population
        $row = 1;
        if (($handle = fopen("/Users/mariusz/Desktop/leadbrowser/app/public/database/worldcities.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $position = $data;

                if ($position[9]) {
                    $city = City::where('name', $position[0])->first();
                    if ($city && !$city->population) {
                        $city->population = $position[9];
                        $city->save();

                        echo "City: " . $row;
                    }
                }

                $row++;
            }
            fclose($handle);
        }
        return;

        $row = 1;
        if (($handle = fopen("/Users/mariusz/Desktop/0.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $position = $data;
                $address = explode(",", $position[6]);

                if (isset($position[7]) && $position[7] != '' && isset($position[2]) && $position[2] != '') {

                    $country = Country::where('name', $position[7])->first();

                    $organization_id = DB::table('organizations')->insertOrIgnore([
                        'id' => $position[0],
                        'title' => $position[1],
                        'website' => $position[2],
                        'year_founded' => $position[3],
                        'classification' => $position[4],
                        'size_range' => $position[5],
                        'formatted_address' => $position[6],
                        'city' => $address[0] ?? '',
                        'state' => isset($address[1]) ? trim($address[1]) : '',
                        'country' => $country->code ?? '',
                        'current_employee_number' => $position[9],
                    ]);

                    if ($position[8]) {
                        DB::table('socials')->insertOrIgnore([
                            'organization_id' => $position[0],
                            'url' => $position[8],
                            'type' => 'linkedin'
                        ]);
                    }
                }

                echo "Organization: " . $row;

                $row++;
            }
            fclose($handle);
        }

        return;

        // $sw = new SimilarWeb;
        // $res = $sw->fetch($website);
        // dd($res);

        $data = [];
    }

    /**
     * Display a terms.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('admin::system.terms');
    }

    /**
     * Display a privacy.
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('admin::system.privacy');
    }

    /**
     * Display a solutions.
     *
     * @return \Illuminate\View\View
     */
    public function solutions()
    {
        return view('admin::system.solutions');
    }

    /**
     * Display a robot.
     *
     * @return \Illuminate\View\View
     */
    public function robot()
    {
        return view('admin::system.robot');
    }

    /**
     * Display a pricing.
     *
     * @return \Illuminate\View\View
     */
    public function pricing()
    {
        $plans = Plan::all();
        return view('admin::system.pricing', compact('plans'));
    }

    /**
     * Display a compare.
     *
     * @return \Illuminate\View\View
     */
    public function compare()
    {
        return view('admin::system.compare');
    }
}
