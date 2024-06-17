<?php
/**
 * ListingsApi.
 *
 * @author   Stefan Neuhaus / ClouSale
 */

/**
 * Selling Partner API for Catalog Items.
 *
 * The Selling Partner API for Catalog Items helps you programmatically retrieve item details for items in the catalog.
 *
 * OpenAPI spec version: v0
 */

namespace ClouSale\AmazonSellingPartnerAPI\Api;

use ClouSale\AmazonSellingPartnerAPI\ApiException;
use ClouSale\AmazonSellingPartnerAPI\Configuration;
use ClouSale\AmazonSellingPartnerAPI\HeaderSelector;
use ClouSale\AmazonSellingPartnerAPI\Helpers\SellingPartnerApiRequest;
use ClouSale\AmazonSellingPartnerAPI\ObjectSerializer;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;

/**
 * CatalogApi Class Doc Comment.
 *
 * @author   Stefan Neuhaus / ClouSale
 */
class ListingsApi
{
    use SellingPartnerApiRequest;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    public function __construct(Configuration $config)
    {
        $this->client = new Client();
        $this->config = $config;
        $this->headerSelector = new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation getCatalogItem.
     *
     * @param string $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param string $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     *
     * @throws ApiException             on non-2xx response
     * @throws InvalidArgumentException
     *
     * @return \ClouSale\AmazonSellingPartnerAPI\Models\Listings\GetListingItemResponse
     */
    public function getListingsItem($marketplace_id, $sku, $sellerId)
    {
        list($response) = $this->getListingsItemWithHttpInfo($marketplace_id, $sku, $sellerId);

        return $response;
    }

    /**
     * Operation getListingsItemWithHttpInfo.
     *
     * @param string $marketplace_id
     * @param string $sku
     * @param string $sellerId
     *
     * @throws ApiException             on non-2xx response
     * @throws InvalidArgumentException
     *
     * @return array of \ClouSale\AmazonSellingPartnerAPI\Models\Listings\GetListingItemResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getListingsItemWithHttpInfo($marketplace_id, $sku, $sellerId)
    {
        $request = $this->getListingsItemRequest($marketplace_id, $sku, $sellerId);

        return $this->sendRequest($request, 'object');
    }

    /**
     * Operation getListingsItemAsync.
     *
     * @param string $marketplace_id A marketplace identifier. Specifies the marketplace for the item. (required)
     * @param string $asin           The Amazon Standard Identification Number (ASIN) of the item. (required)
     *
     * @throws InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getListingsItemAsync($marketplace_id, $sku, $sellerId)
    {
        return $this->getListingsItemWithHttpInfo($marketplace_id, $sku, $sellerId)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Create request for operation 'getListingsItem'.
     * @param $marketplace_id
     * @param $sku
     * @param $sellerId
     * @return mixed
     */
    protected function getListingsItemRequest($marketplace_id, $sku, $sellerId)
    {
        // verify the required parameter 'marketplace_id' is set
        if (null === $marketplace_id || (is_array($marketplace_id) && 0 === count($marketplace_id))) {
            throw new InvalidArgumentException('Missing the required parameter $marketplace_id when calling getCatalogItem');
        }
        // verify the required parameter 'asin' is set
        if (null === $sku || (is_array($sku) && 0 === count($sku))) {
            throw new InvalidArgumentException('Missing the required parameter $asin when calling getCatalogItem');
        }

        $resourcePath = '/listings/2021-08-01/items/{sellerId}/{sku}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if (null !== $marketplace_id) {
            $queryParams['marketplaceIds'] = ObjectSerializer::toQueryValue($marketplace_id);
        }

        // path params
        if (null !== $sku) {
            $resourcePath = str_replace(
                '{'.'sku'.'}',
                ObjectSerializer::toPathValue($sku),
                $resourcePath
            );
        }

        // path params
        if (null !== $sellerId) {
            $resourcePath = str_replace(
                '{'.'sellerId'.'}',
                ObjectSerializer::toPathValue($sellerId),
                $resourcePath
            );
        }

        return $this->generateRequest($multipart, $formParams, $queryParams, $resourcePath, $headerParams, 'GET', $httpBody);
    }
}
