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
use LeadBrowser\Extractor\Traits\Email\LinkedinExtractor;
use LeadBrowser\Payment\Models\Plan;
use LeadBrowser\Extractor\Services\Crawler;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Search\Models\SearchLocations;
use LeadBrowser\Search\Services\SearchService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

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
        $collection = $this->searchDomainInLinkedin("https://www.dmsales.com/");
        dd($collection);

        ini_set('memory_limit', '1512M');
        ini_set('max_execution_time', '18880');

        // CITIES
        $row = 1;
        if (($handle = fopen("/Users/mariusz/Desktop/leadbrowser/Application/geonames-all-cities-with-a-population-1000.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // if ($row == 1) continue;

                $position = $data;

                if (isset($position[13]) && $position[13] != '') {

                    // dd($position[13]);
                    
                    $city = City::where('name', $position[1])->orWhere('name', $position[2])->orWhere('name', $position[3])->first();

                    if ($city) {
                        $city->population = $position[13];
                        $city->save();
                    }
                }

                $row++;
            }
            fclose($handle);
        }

        return;


        $row = 1;
        if (($handle = fopen("/Users/mariusz/Desktop/leadbrowser/Application/companies_sorted.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $position = $data;
                $address = explode(",", $position[6]);

                if (isset($position[7]) && $position[7] != '' && isset($position[2]) && $position[2] != '') {
                    
                    $country = Country::where('name', $position[7])->first();

                    DB::table('organizations')->insertOrIgnore([
                        'title' => $position[1],
                        'website' => $position[2],
                        'year_founded' => $position[3],
                        'types' => $position[4],
                        'size_range' => $position[5],
                        'formatted_address' => $position[6],
                        'city' => $address[0] ?? '',
                        'state' => isset($address[1]) ? trim($address[1]) : '',
                        'country' => $country->code ?? '',
                        'current_employee_number' => $position[9],
                    ]);
                }

                $row++;
            }
            fclose($handle);
        }

        return;

        // $sw = new SimilarWeb;
        // $res = $sw->fetch($website);
        // dd($res);

        // $ai = new GIWY("5ma-l22mal-1mzOAzmaa1022-Xaa2");
        // $result = $ai->fetch($website);
        // dd($result);

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
