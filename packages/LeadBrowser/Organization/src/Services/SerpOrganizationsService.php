<?php

declare(strict_types=1);

namespace LeadBrowser\Organization\Services;

use App\Services\GoogleMapService;
use Exception;
use LeadBrowser\Admin\Http\Resources\ResultResource;
use Illuminate\Support\Facades\Log;
use LeadBrowser\Organization\Models\Organization;
use LeadBrowser\Result\Models\Result;
use LeadBrowser\Core\Models\City;
use LeadBrowser\Core\Models\Country;
use LeadBrowser\Extractor\SerpAPI\SerpAPI;
use LeadBrowser\Organization\Traits\Organizationable;
use LeadBrowser\Search\Models\SearchLocations;

use LeadBrowser\Search\Models\Type;

class SerpOrganizationsService
{
    use Organizationable;
    
    /**
     * @var String
     */
    public $pagetoken;

    public function __construct()
    {
        $this->pagetoken = 0;
    }

    /**
     * @param SearchLocations $search
     * @param string $title
     * @param int $next_page_token
     * 
     * @return object|boolean
     */
    public function searchByCities(int $search_id, $title, $next_page_token = 0, $cities, $country, $threshold, $search_results_count)
    {
        $num = 0;
        
        /**
         * Get page token
         */
        $this->pagetoken = $next_page_token;

        $type_parent = Type::where('name', $title)->where('parent_id', 0)->first();

        $page = 1;
  
        foreach ($cities as $city) {

            $country_code = $country->code;
            $country_name = $country->name;
            $state_name = '';

            /**
             * Search in city
             */
            Log::info('Search API: ' . $title . ' in ' . $city . ' ' . $state_name . ' ' . $country->code . ' search...');

            while ($page >= 1) {
                
                $location = $city . ',' . $state_name . ',' . $country_name;
                
                $url = $title . ' in ' . $location;

                $serp = new SerpAPI();
                $collection = $serp->search($url, $location, ['search_type' => 'places'], $page);
                $results = $collection->places_results ?? [];

                isset($collection->pagination) ? $page++ : $page = 0;

                /**
                 * Save next page token and last city ID
                 */
                $search = SearchLocations::findOrFail($search_id);
                $search->last_city_id = $city;//$city->id;
                $search->next_page_token = $page;
                $search->save();

                Log::info('Search API: Found ' . count($results) . ' organizations');

                if(!empty($results)) {
                    foreach ($results as $key => $result) {

                        $data_id = $result->data_cid ?? $result->data_id;
                        $data_id_type = isset($result->data_cid) ? 'data_cid' : 'data_id';

                        // TODO: Warning organization!
                        if(!isset($data_id)) continue;

                        $category = $result->category ?? $title;

                        // If dosent find, create new one
                        $type_child = Type::where('name', $category)->where('parent_id', '!=', 0)->first();
                        if (!$type_child) {
                            Type::create([
                                'parent_id' => $type_parent->id,
                                'name' => $category
                            ]);
                        }

                        // // If category is wrong
                        // if(!$search->typesByName($result->category)) continue;

                        $organization = $this->searchOrganizationBy($data_id, 'place_id');

                        if ($threshold <= ($search_results_count + $num)) break 3;
                        if (!$search->search_status) break 3;

                        if(!$organization) {

                            if(!isset($result->link) && $data_id) {
                                // Search details
                                $data = $serp->search($title, $location, ['search_type' => 'place_details', $data_id_type => $data_id]);
                                $result->link = $data->place_details->website ?? '';
                            }

                            if($result) {
                                $organization = new Organization();
                                $organization->title = $this->cleanTitle($result->title);
                                $organization->rating = $result->rating ?? '';
                                $organization->types = $category;
                                $organization->formatted_address = $result->address ?? '';
                                $organization->user_ratings_total = $result->reviews ?? '';
                                $organization->place_id = $data_id;
                                $organization->lat = isset($result->gps_coordinates) ? $result->gps_coordinates->latitude : '';
                                $organization->lng = isset($result->gps_coordinates) ? $result->gps_coordinates->longitude : '';
                                // $organization->business_status = ''; //$detail['business_status'];
                                $organization->price = $result->price_description ?? '';
                                $organization->country = $country_code;
                                $organization->city = $city;
                                $organization->state = $state_name;
                                $organization->website = $result->link;
                                $organization->formatted_phone_number = $result->phone ?? '';
                                $organization->international_phone_number = $result->phone ?? '';
                                $organization->is_sponsored = $result->sponsored ?? false;
                                $organization->save();
                            }
                        
                            ++$num;
                        }
                    }
                } else {
                    break;
                }
                
                // Update localization count
                Log::info('Search API: Go to next page');
            }
            
            $page = 0;
        }

        Log::info('Search API: We created ' . $num . ' organizations');
        Log::info('Search API: The search is complete');
    }

    /**
     * @param Organization $organization
     */
    public function searchOrganization($organization_id)
    {

    }

    /**
     * @param $phone
     */
    public function searchByPhone($phone)
    {
        $googleMapService = new GoogleMapService($phone);
        $googleMapData = $googleMapService->generatePlaceByPhonenumber();

        return $googleMapData;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function cleanWebsiteUrl(string $url): string
    {
        return strtok($url, "?");
    }

    /**
     * @param string $dirtyText
     */
    protected function cleanTitle(string $dirtyText): string
    {
        $text = preg_replace('%(?:
            \xF0[\x90-\xBF][\x80-\xBF]{2}
            | [\xF1-\xF3][\x80-\xBF]{3}
            | \xF4[\x80-\x8F][\x80-\xBF]{2}
        )%xs', '', $dirtyText);

        return mb_substr($text, 0, 35);
    }
}