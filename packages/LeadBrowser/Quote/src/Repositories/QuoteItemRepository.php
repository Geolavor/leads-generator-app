<?php

namespace LeadBrowser\Quote\Repositories;

use Illuminate\Container\Container;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Product\Repositories\ProductRepository;

class QuoteItemRepository extends Repository
{
    /**
     * ProductRepository object
     *
     * @var \LeadBrowser\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * Create a new repository instance.
     *
     * @param  \LeadBrowser\Product\Repositories\ProductRepository  $productRepository
     * @param  \Illuminate\Container\Container  $container
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        Container $container
    )
    {
        $this->productRepository = $productRepository;

        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'LeadBrowser\Quote\Contracts\QuoteItem';
    }

    /**
     * @param array $data
     * @return \LeadBrowser\Quote\Contracts\QuoteItem
     */
    public function create(array $data)
    {
        $product = $this->productRepository->findOrFail($data['product_id']);

        $quoteItem = parent::create(array_merge($data, [
            'sku'  => $product->sku,
            'name' => $product->name,
        ]));

        return $quoteItem;
    }

    /**
     * @param array  $data
     * @param int    $id
     * @param string $attribute
     * @return \LeadBrowser\Quote\Contracts\QuoteItem
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $product = $this->productRepository->findOrFail($data['product_id']);

        $quoteItem = parent::update(array_merge($data, [
            'sku'  => $product->sku,
            'name' => $product->name,
        ]), $id);

        return $quoteItem;
    }
}