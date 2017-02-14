<?php

namespace BlueMedia\OnlinePayments\Model;

use DomainException;

/**
 * Model for product list.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
 */
class ProductList extends AbstractModel
{

    /**
     * Products.
     *
     * @var array
     */
    private $products = array();

    /**
     * Adds product.
     *
     * @param  Product $product
     * @return $this
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Resturns products.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Validates model.
     *
     * @throws DomainException
     */
    public function validate()
    {
        if (empty($this->getProducts())) {
            throw new DomainException('Products cannot be empty');
        }
    }
}
