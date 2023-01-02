<?php

namespace LeadBrowser\Result\Repositories;

use Illuminate\Container\Container;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Attribute\Repositories\AttributeValueRepository;
use LeadBrowser\Result\Models\Result;

class ResultRepository extends Repository
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

        // TODO
        // parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Result\Contracts\Result';
    }

    /**
     * @param array $data
     * @return \LeadBrowser\Result\Contracts\Result
     */
    public function create(array $data)
    {
        // $product = parent::create($data);
        $product = Result::create($data);

        $this->attributeValueRepository->save($data, $product->id);

        return $product;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Result\Contracts\Result
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
    public function getResultCount($startDate, $endDate)
    {
        return $this
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->count();
    }
}