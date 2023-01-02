<?php

namespace LeadBrowser\Organization\Repositories;

use Illuminate\Container\Container;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Attribute\Repositories\AttributeValueRepository;

class PersonRepository extends Repository
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
     * @param  \LeadBrowser\Attribute\Repositories\AttributeValueRepository $attributeValueRepository
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
        return 'LeadBrowser\Organization\Contracts\Person';
    }

    /**
     * @param array $data
     * @return \LeadBrowser\Organization\Contracts\Person
     */
    public function create(array $data)
    {
        // TODO
        // $data['user_id'] = auth()->guard('user')->user()->id;

        $person = parent::create($data);

        $this->attributeValueRepository->save($data, $person->id);

        return $person;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Organization\Contracts\Person
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $person = parent::update($data, $id);

        $this->attributeValueRepository->save($data, $id);

        return $person;
    }

    /**
     * Retrieves customers count based on date
     *
     * @return number
     */
    public function getCustomerCount($startDate, $endDate)
    {
        return $this
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->count();
    }
}