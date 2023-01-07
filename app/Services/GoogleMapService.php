<?php

namespace App\Services;

use App\Integrations\GoogleMaps\GoogleMaps;

class GoogleMapService
{
    /**
     * The target title.
     *
     * @var string
     */
    public $title;

    /**
     * The target language.
     *
     * @var mixed string
     */
    public $language;

    /**
     * The target type.
     *
     * @var mixed string
     */
    public $type;

    /**
     * The target latitude.
     *
     * @var mixed string
     */
    public $latitude;

    /**
     * The target longitude.
     *
     * @var mixed string
     */
    public $longitude;

    /**
     * The target radius.
     *
     * @var mixed string
     */
    public $radius;

    /**
     * Set the resource map that will hold the the search info.
     *
     * @param string $title
     * @param float $latitude
     * @param float $longitude
     * @param string $radius
     * @param string $language
     * @param string $type
     * @return $this
     */
    public function __construct(string $title, float $latitude = null, float $longitude = null, string $radius = '5000', string $language = 'pl', string $type = '')
    {
        $this->title = $title;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->radius = $radius;
        $this->language = $language;
        $this->type = $type;
        
        $this->response = new GoogleMaps;
    }

    /**
     * @param string $pagetoken
     */
    public function generateOrganizations(string $pagetoken = null)
    {
        $data = $this->response->load('textsearch')
        ->setParam([
            'query' => $this->title,
            'language' => $this->language,
            'type' => $this->type,
            'pagetoken' => $pagetoken,
            'region ' => '',
            'location' => $this->latitude . ',' . $this->longitude,
            'radius' => $this->radius
        ])
        ->get();

        return json_decode($data, true);
    }

    /**
     * @param string $id
     */
    public function generatePlaceDetail(string $id)
    {
        $data = $this->response->load('placedetails')
        ->setParam([
            'place_id' => $id,
            'language' => $this->language,
        ])
        ->get();

        $result = json_decode($data, true);
      
        return $result['result'];
    }

    /**
     */
    public function generatePlaceByPhonenumber()
    {
        $data = $this->response->load('findplace')
        ->setParam([
            'input'     => $this->title,
            'inputtype' => 'phonenumber'
        ])
        ->get();

        $result = json_decode($data, true);
      
        return $result;
    }

    public function changePage( $token )
    {
        return isset($token) ? $token : null;
    }

    function cleanTitle($string)
    {
        $text = preg_replace('%(?:
            \xF0[\x90-\xBF][\x80-\xBF]{2}
            | [\xF1-\xF3][\x80-\xBF]{3}
            | \xF4[\x80-\x8F][\x80-\xBF]{2}
        )%xs', '', $string);

        return mb_substr($text, 0, 35);
    }
}