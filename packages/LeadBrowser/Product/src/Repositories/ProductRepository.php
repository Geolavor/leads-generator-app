<?php

namespace LeadBrowser\Product\Repositories;

use Illuminate\Container\Container;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Attribute\Repositories\AttributeValueRepository;

class ProductRepository extends Repository
{
    /**
     * AttributeValueRepository object
     *
     * @var \LeadBrowser\Attribute\Repositories\AttributeValueRepository
     */
    protected $attributeValueRepository;

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Attribute\Repositories\AttributeValueRepository  $attributeValueRepository
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        AttributeValueRepository $attributeValueRepository,
        Container $container
    )
    {
        $this->attributeValueRepository = $attributeValueRepository;

        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Product\Contracts\Product';
    }

    /**
     * @param array $data
     * @return \LeadBrowser\Product\Contracts\Product
     */
    public function create(array $data)
    {
        // TODO
        $data['user_id'] = auth()->guard('user')->user()->id;
        
        $product = parent::create($data);

        $this->attributeValueRepository->save($data, $product->id);

        return $product;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Product\Contracts\Product
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $product = parent::update($data, $id);

        $this->attributeValueRepository->save($data, $id);

        return $product;
    }

    /**
     * Retreives customers count based on date
     *
     * @return number
     */
    public function getProductCount($startDate, $endDate)
    {
        return $this
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->count();
    }
}