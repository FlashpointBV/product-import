<?php

namespace BigBridge\ProductImport\Model\Resource;

use BigBridge\ProductImport\Model\Data\CategoryInfo;
use BigBridge\ProductImport\Model\Data\EavAttributeInfo;
use BigBridge\ProductImport\Model\Data\LinkInfo;
use BigBridge\ProductImport\Model\Persistence\Magento2DbConnection;

/**
 * Pre-loads all meta data needed for the core processes once.
 *
 * @author Patrick van Bergen
 */
class MetaData
{
    const ENTITY_TYPE_TABLE = 'eav_entity_type';
    const PRODUCT_ENTITY_TABLE = 'catalog_product_entity';
    const CATEGORY_ENTITY_TABLE = 'catalog_category_entity';
    const URL_REWRITE_TABLE = 'url_rewrite';
    const URL_REWRITE_PRODUCT_CATEGORY_TABLE = 'catalog_url_rewrite_product_category';
    const CATEGORY_PRODUCT_TABLE = 'catalog_category_product';
    const CONFIG_DATA_TABLE = 'core_config_data';
    const ATTRIBUTE_SET_TABLE = 'eav_attribute_set';
    const ATTRIBUTE_TABLE = 'eav_attribute';
    const ATTRIBUTE_OPTION_TABLE = 'eav_attribute_option';
    const ATTRIBUTE_OPTION_VALUE_TABLE = 'eav_attribute_option_value';
    const CATALOG_ATTRIBUTE_TABLE = 'catalog_eav_attribute';
    const STORE_TABLE = 'store';
    const WEBSITE_TABLE = 'store_website';
    const TAX_CLASS_TABLE = 'tax_class';
    const CUSTOMER_GROUP_TABLE = 'customer_group';
    const PRODUCT_WEBSITE_TABLE = 'catalog_product_website';
    const MEDIA_GALLERY_TABLE = 'catalog_product_entity_media_gallery';
    const MEDIA_GALLERY_VALUE_TO_ENTITY_TABLE = 'catalog_product_entity_media_gallery_value_to_entity';
    const MEDIA_GALLERY_VALUE_TABLE = 'catalog_product_entity_media_gallery_value';
    const STOCK_ITEM_TABLE = 'cataloginventory_stock_item';
    const SUPER_ATTRIBUTE_TABLE = 'catalog_product_super_attribute';
    const SUPER_ATTRIBUTE_LABEL_TABLE = 'catalog_product_super_attribute_label';
    const SUPER_LINK_TABLE = 'catalog_product_super_link';
    const RELATION_TABLE = 'catalog_product_relation';
    const LINK_TABLE = 'catalog_product_link';
    const LINK_ATTRIBUTE_TABLE = 'catalog_product_link_attribute';
    const LINK_ATTRIBUTE_INT_TABLE = 'catalog_product_link_attribute_int';
    const LINK_ATTRIBUTE_DECIMAL_TABLE = 'catalog_product_link_attribute_decimal';
    const LINK_TYPE_TABLE = 'catalog_product_link_type';
    const TIER_PRICE_TABLE = 'catalog_product_entity_tier_price';
    const DOWNLOADABLE_LINK_TABLE = 'downloadable_link';
    const DOWNLOADABLE_LINK_TITLE_TABLE = 'downloadable_link_title';
    const DOWNLOADABLE_LINK_PRICE_TABLE = 'downloadable_link_price';
    const DOWNLOADABLE_SAMPLE_TABLE = 'downloadable_sample';
    const DOWNLOADABLE_SAMPLE_TITLE_TABLE = 'downloadable_sample_title';
    const BUNDLE_OPTION_TABLE = 'catalog_product_bundle_option';
    const BUNDLE_OPTION_VALUE_TABLE = 'catalog_product_bundle_option_value';
    const BUNDLE_SELECTION_TABLE = 'catalog_product_bundle_selection';
    const CUSTOM_OPTION_TABLE = 'catalog_product_option';
    const CUSTOM_OPTION_PRICE_TABLE = 'catalog_product_option_price';
    const CUSTOM_OPTION_TITLE_TABLE = 'catalog_product_option_title';
    const CUSTOM_OPTION_TYPE_PRICE_TABLE = 'catalog_product_option_type_price';
    const CUSTOM_OPTION_TYPE_TITLE_TABLE = 'catalog_product_option_type_title';
    const CUSTOM_OPTION_TYPE_VALUE_TABLE = 'catalog_product_option_type_value';

    const TYPE_DATETIME = 'datetime';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_INTEGER = 'int';
    const TYPE_VARCHAR = 'varchar';
    const TYPE_TEXT = 'text';

    /** @var  Magento2DbConnection */
    protected $db;

    /** @var string  */
    public $entityTypeTable;

    /** @var  string  */
    public $productEntityTable;

    /** @var string */
    public $categoryEntityTable;

    /** @var string */
    public $urlRewriteTable;

    /** @var string */
    public $urlRewriteProductCategoryTable;

    /** @var  string */
    public $categoryProductTable;

    /** @var  string */
    public $configDataTable;

    /** @var  string */
    public $productWebsiteTable;

    /** @var string */
    public $mediaGalleryTable;

    /** @var string */
    public $mediaGalleryValueToEntityTable;

    /** @var string */
    public $mediaGalleryValueTable;

    /** @var string */
    public $stockItemTable;

    /** @var string */
    public $superAttributeTable;

    /** @var string */
    public $superAttributeLabelTable;

    /** @var string */
    public $superLinkTable;

    /** @var string */
    public $relationTable;

    /** @var string  */
    public $attributeTable;

    /** @var string  */
    public $catalogAttributeTable;

    /** @var string  */
    public $attributeOptionTable;

    /** @var string */
    public $attributeOptionValueTable;

    /** @var string */
    public $attributeSetTable;

    /** @var string */
    public $storeTable;

    /** @var string */
    public $websiteTable;

    /** @var string */
    public $taxClassTable;

    /** @var string */
    public $customerGroupTable;

    /** @var string */
    public $linkTable;

    /** @var string */
    public $linkAttributeTable;

    /** @var string */
    public $linkAttributeIntTable;

    /** @var string */
    public $linkAttributeDecimalTable;

    /** @var string */
    public $linkTypeTable;

    /** @var string */
    public $tierPriceTable;

    /** @var string */
    public $downloadableLinkTable;

    /** @var string */
    public $downloadableLinkTitleTable;

    /** @var string */
    public $downloadableLinkPriceTable;

    /** @var string */
    public $downloadableSampleTable;

    /** @var string */
    public $downloadableSampleTitleTable;

    /** @var string */
    public $bundleOptionTable;

    /** @var string */
    public $bundleOptionValueTable;

    /** @var string */
    public $bundleSelectionTable;

    /** @var string */
    public $customOptionTable;

    /** @var string */
    public $customOptionPriceTable;

    /** @var string */
    public $customOptionTitleTable;

    /** @var string */
    public $customOptionTypePriceTable;

    /** @var string */
    public $customOptionTypeTitleTable;

    /** @var string */
    public $customOptionTypeValueTable;

    /** @var  int */
    public $defaultCategoryAttributeSetId;

    /** @var array Maps attribute set name to id */
    public $productAttributeSetMap;

    /** @var array Maps tax class name to id */
    public $taxClassMap;

    /** @var array Maps store view code to id */
    public $storeViewMap;

    /** @var array Maps store view id to website id */
    public $storeViewWebsiteMap;

    /** @var  array Maps website code to id */
    public $websiteMap;

    /** @var array Maps customer group name to id */
    public $customerGroupMap;

    /** @var int  */
    public $productEntityTypeId;

    /** @var int  */
    public $categoryEntityTypeId;

    /** @var  EavAttributeInfo[] */
    public $productEavAttributeInfo;

    /** @var int */
    public $mediaGalleryAttributeId;

    /** @var array */
    public $categoryAttributeMap;

    /** @var  string */
    public $productUrlSuffix;

    /** @var  string */
    public $categoryUrlSuffix;

    /** @var bool Create 301 rewrite for older url_rewrite entries */
    public $saveRewritesHistory;

    /** @var CategoryInfo[] */
    public $allCategoryInfo;

    /** @var LinkInfo[] */
    public $linkInfo;

    public function __construct(Magento2DbConnection $db)
    {
        $this->db = $db;

        $this->entityTypeTable = $this->db->getFullTableName(self::ENTITY_TYPE_TABLE);
        $this->productEntityTable = $db->getFullTableName(self::PRODUCT_ENTITY_TABLE);
        $this->categoryEntityTable = $db->getFullTableName(self::CATEGORY_ENTITY_TABLE);
        $this->urlRewriteTable = $db->getFullTableName(self::URL_REWRITE_TABLE);
        $this->urlRewriteProductCategoryTable = $db->getFullTableName(self::URL_REWRITE_PRODUCT_CATEGORY_TABLE);
        $this->categoryProductTable = $db->getFullTableName(self::CATEGORY_PRODUCT_TABLE);
        $this->configDataTable = $db->getFullTableName(self::CONFIG_DATA_TABLE);
        $this->productWebsiteTable = $db->getFullTableName(self::PRODUCT_WEBSITE_TABLE);
        $this->mediaGalleryTable = $db->getFullTableName(self::MEDIA_GALLERY_TABLE);
        $this->mediaGalleryValueToEntityTable = $db->getFullTableName(self::MEDIA_GALLERY_VALUE_TO_ENTITY_TABLE);
        $this->mediaGalleryValueTable = $db->getFullTableName(self::MEDIA_GALLERY_VALUE_TABLE);
        $this->stockItemTable = $db->getFullTableName(self::STOCK_ITEM_TABLE);
        $this->superAttributeTable = $db->getFullTableName(self::SUPER_ATTRIBUTE_TABLE);
        $this->superAttributeLabelTable = $db->getFullTableName(self::SUPER_ATTRIBUTE_LABEL_TABLE);
        $this->superLinkTable = $db->getFullTableName(self::SUPER_LINK_TABLE);
        $this->relationTable = $db->getFullTableName(self::RELATION_TABLE);
        $this->attributeTable = $this->db->getFullTableName(self::ATTRIBUTE_TABLE);
        $this->catalogAttributeTable = $this->db->getFullTableName(self::CATALOG_ATTRIBUTE_TABLE);
        $this->attributeOptionTable = $this->db->getFullTableName(self::ATTRIBUTE_OPTION_TABLE);
        $this->attributeOptionValueTable = $this->db->getFullTableName(self::ATTRIBUTE_OPTION_VALUE_TABLE);
        $this->attributeSetTable = $this->db->getFullTableName(self::ATTRIBUTE_SET_TABLE);
        $this->storeTable = $this->db->getFullTableName(self::STORE_TABLE);
        $this->websiteTable = $this->db->getFullTableName(self::WEBSITE_TABLE);
        $this->taxClassTable = $this->db->getFullTableName(self::TAX_CLASS_TABLE);
        $this->linkTable = $this->db->getFullTableName(self::LINK_TABLE);
        $this->linkAttributeTable = $this->db->getFullTableName(self::LINK_ATTRIBUTE_TABLE);
        $this->linkAttributeIntTable = $this->db->getFullTableName(self::LINK_ATTRIBUTE_INT_TABLE);
        $this->linkAttributeDecimalTable = $this->db->getFullTableName(self::LINK_ATTRIBUTE_DECIMAL_TABLE);
        $this->linkTypeTable = $this->db->getFullTableName(self::LINK_TYPE_TABLE);
        $this->customerGroupTable = $this->db->getFullTableName(self::CUSTOMER_GROUP_TABLE);
        $this->tierPriceTable = $this->db->getFullTableName(self::TIER_PRICE_TABLE);
        $this->downloadableLinkTable = $this->db->getFullTableName(self::DOWNLOADABLE_LINK_TABLE);
        $this->downloadableLinkTitleTable = $this->db->getFullTableName(self::DOWNLOADABLE_LINK_TITLE_TABLE);
        $this->downloadableLinkPriceTable = $this->db->getFullTableName(self::DOWNLOADABLE_LINK_PRICE_TABLE);
        $this->downloadableSampleTable = $this->db->getFullTableName(self::DOWNLOADABLE_SAMPLE_TABLE);
        $this->downloadableSampleTitleTable = $this->db->getFullTableName(self::DOWNLOADABLE_SAMPLE_TITLE_TABLE);
        $this->bundleOptionTable = $this->db->getFullTableName(self::BUNDLE_OPTION_TABLE);
        $this->bundleOptionValueTable = $this->db->getFullTableName(self::BUNDLE_OPTION_VALUE_TABLE);
        $this->bundleSelectionTable = $this->db->getFullTableName(self::BUNDLE_SELECTION_TABLE);
        $this->customOptionTable = $this->db->getFullTableName(self::CUSTOM_OPTION_TABLE);
        $this->customOptionTitleTable = $this->db->getFullTableName(self::CUSTOM_OPTION_TITLE_TABLE);
        $this->customOptionPriceTable = $this->db->getFullTableName(self::CUSTOM_OPTION_PRICE_TABLE);
        $this->customOptionTypeTitleTable = $this->db->getFullTableName(self::CUSTOM_OPTION_TYPE_TITLE_TABLE);
        $this->customOptionTypePriceTable = $this->db->getFullTableName(self::CUSTOM_OPTION_TYPE_PRICE_TABLE);
        $this->customOptionTypeValueTable = $this->db->getFullTableName(self::CUSTOM_OPTION_TYPE_VALUE_TABLE);

        $this->productEntityTypeId = $this->getProductEntityTypeId();
        $this->categoryEntityTypeId = $this->getCategoryEntityTypeId();

        $this->defaultCategoryAttributeSetId = $this->getDefaultCategoryAttributeSetId();

        $this->categoryAttributeMap = $this->getCategoryAttributeMap();
        $this->productAttributeSetMap = $this->getProductAttributeSetMap();
        $this->productEavAttributeInfo = $this->getProductEavAttributeInfo();
        $this->mediaGalleryAttributeId = $this->getMediaGalleryAttributeId();

        $this->storeViewMap = $this->getStoreViewMap();
        $this->storeViewWebsiteMap = $this->getStoreViewWebsiteMap();
        $this->websiteMap = $this->getWebsiteMap();
        $this->taxClassMap = $this->getTaxClassMap();
        $this->customerGroupMap = $this->getCustomerGroupMap();

        $this->productUrlSuffix = $this->getProductUrlSuffix();
        $this->categoryUrlSuffix = $this->getCategoryUrlSuffix();
        $this->saveRewritesHistory  = $this->getSaveRewritesHistory();

        $this->allCategoryInfo = $this->getAllCategoryInfo();

        $this->linkInfo = $this->getLinkInfo();
    }

    /**
     * Returns the id of the default category attribute set id.
     *
     * @return int
     */
    protected function getDefaultCategoryAttributeSetId()
    {
        return $this->db->fetchSingleCell("SELECT `default_attribute_set_id` FROM {$this->entityTypeTable} WHERE `entity_type_code` = 'catalog_category'");
    }

    /**
     * Returns the id of the product entity type.
     *
     * @return int
     */
    protected function getProductEntityTypeId()
    {
        return $this->db->fetchSingleCell("SELECT `entity_type_id` FROM {$this->entityTypeTable} WHERE `entity_type_code` = 'catalog_product'");
    }

    /**
     * Returns the id of the category entity type.
     *
     * @return int
     */
    protected function getCategoryEntityTypeId()
    {
        return $this->db->fetchSingleCell("SELECT `entity_type_id` FROM {$this->entityTypeTable} WHERE `entity_type_code` = 'catalog_category'");
    }

    /**
     * Returns a name => id map for product attribute sets.
     *
     * @return array
     */
    protected function getProductAttributeSetMap()
    {
        return $this->db->fetchMap(
            "SELECT `attribute_set_name`, `attribute_set_id` FROM {$this->attributeSetTable} WHERE `entity_type_id` = ?
        ", [
                $this->productEntityTypeId
        ]);
    }

    /**
     * Returns a code => id map for store views.
     *
     * @return array
     */
    protected function getStoreViewMap()
    {
        return $this->db->fetchMap("SELECT `code`, `store_id` FROM {$this->storeTable}");
    }

    protected function getStoreViewWebsiteMap()
    {
        return $this->db->fetchMap("SELECT `store_id`, `website_id` FROM {$this->storeTable}");
    }

    /**
     * Returns a code => id map for websites.
     *
     * @return array
     */
    protected function getWebsiteMap()
    {
        return $this->db->fetchMap("SELECT `code`, `website_id` FROM {$this->websiteTable}");
    }

    /**
     * Returns a code => id map for tax classes.
     *
     * @return array
     */
    protected function getTaxClassMap()
    {
        return $this->db->fetchMap("SELECT `class_name`, `class_id` FROM {$this->taxClassTable}");
    }

    /**
     * Returns a customer code (name) => id array
     *
     * @return array
     */
    protected function getCustomerGroupMap()
    {
        return $this->db->fetchMap("SELECT `customer_group_code`, `customer_group_id` FROM {$this->customerGroupTable}");
    }

    /**
     * Returns a name => id map for category attributes.
     *
     * @return array
     */
    protected function getCategoryAttributeMap()
    {
        return $this->db->fetchMap(
            "SELECT `attribute_code`, `attribute_id` FROM {$this->attributeTable} WHERE `entity_type_id` = ?
        ", [
            $this->categoryEntityTypeId
        ]);
    }
    
    /**
     * @return array An attribute code indexed array of AttributeInfo
     */
    protected function getProductEavAttributeInfo()
    {
        $optionValueRows = $this->db->fetchAllAssoc("
            SELECT A.`attribute_code`, O.`option_id`, V.`value`
            FROM {$this->attributeTable} A
            INNER JOIN {$this->attributeOptionTable} O ON O.attribute_id = A.attribute_id
            INNER JOIN {$this->attributeOptionValueTable} V ON V.option_id = O.option_id
            WHERE A.`entity_type_id` = ? AND A.frontend_input IN ('select', 'multiselect') AND V.store_id = 0
        ", [
            $this->productEntityTypeId
        ]);

        $allOptionValues = [];
        foreach ($optionValueRows as $row) {
            $allOptionValues[$row['attribute_code']][$row['value']] = $row['option_id'];
        }

        $rows = $this->db->fetchAllAssoc("
            SELECT A.`attribute_id`, A.`attribute_code`, A.`is_required`, A.`backend_type`, A.`frontend_input`, C.`is_global` 
            FROM {$this->attributeTable} A
            INNER JOIN {$this->catalogAttributeTable} C ON C.`attribute_id` = A.`attribute_id`
            WHERE A.`entity_type_id` = ? AND A.backend_type != 'static'
         ", [
            $this->productEntityTypeId
        ]);

        $info = [];
        foreach ($rows as $row) {

            $optionValues = array_key_exists($row['attribute_code'], $allOptionValues) ? $allOptionValues[$row['attribute_code']] : [];

            $info[$row['attribute_code']] = new EavAttributeInfo(
                $row['attribute_code'],
                (int)$row['attribute_id'],
                (bool)$row['is_required'],
                $row['backend_type'],
                $this->productEntityTable . '_' . $row['backend_type'],
                $row['frontend_input'],
                $optionValues,
                $row['is_global']);
        }

        return $info;
    }

    public function addAttributeOption(string $attributeCode, string $optionName): int
    {
        $attributeId = $this->productEavAttributeInfo[$attributeCode]->attributeId;

        $lastOrderIndex = $this->db->fetchSingleCell("
            SELECT MAX(sort_order)
            FROM {$this->attributeOptionTable}
            WHERE attribute_id = $attributeId
        ");

        $sortOrder = is_null($lastOrderIndex) ? 1 : ($lastOrderIndex + 1);

        $this->db->execute("
            INSERT INTO {$this->attributeOptionTable}
            SET attribute_id = ?, sort_order = ?
        ", [
            $attributeId,
            $sortOrder
        ]);

        $optionId = $this->db->getLastInsertId();

        // update cached values
        $this->productEavAttributeInfo[$attributeCode]->optionValues[$optionName] = $optionId;

        $this->db->execute("
            INSERT INTO {$this->attributeOptionValueTable}
            SET option_id = ?, store_id = 0, value = ?
        ", [
            $optionId,
            $optionName
        ]);

        return $optionId;
    }

    protected function getMediaGalleryAttributeId()
    {
        $attributeTable = $this->db->getFullTableName(self::ATTRIBUTE_TABLE);

        return $this->db->fetchSingleCell("
            SELECT `attribute_id` 
            FROM {$attributeTable} 
            WHERE `entity_type_id` = ? AND attribute_code = 'media_gallery'
        ", [
            $this->productEntityTypeId
        ]);

    }

    protected function getCategoryUrlSuffix()
    {
        $value = $this->db->fetchSingleCell("
            SELECT `value`
            FROM `{$this->configDataTable}`
            WHERE
                `scope` = 'default' AND
                `scope_id` = 0 AND
                `path` = 'catalog/seo/category_url_suffix'
        ");

        return is_null($value) ? ".html" : $value;
    }

    protected function getSaveRewritesHistory()
    {
        $value = $this->db->fetchSingleCell("
            SELECT `value`
            FROM `{$this->configDataTable}`
            WHERE
                `scope` = 'default' AND
                `scope_id` = 0 AND
                `path` = 'catalog/seo/save_rewrites_history'
        ");

        return is_null($value) ? true : (bool)$value;
    }

    protected function getProductUrlSuffix()
    {
        $value = $this->db->fetchSingleCell("
            SELECT `value`
            FROM `{$this->configDataTable}`
            WHERE
                `scope` = 'default' AND
                `scope_id` = 0 AND
                `path` = 'catalog/seo/product_url_suffix'
        ");

        return is_null($value) ? ".html" : $value;
    }

    /**
     * @return CategoryInfo[]
     */
    protected function getAllCategoryInfo()
    {
        $urlKeyAttributeId = $this->categoryAttributeMap['url_key'];

        $categoryData = $this->db->fetchAllAssoc("
            SELECT E.`entity_id`, E.`path`, URL_KEY.`value` as url_key, URL_KEY.`store_id`
            FROM `{$this->categoryEntityTable}` E
            LEFT JOIN `{$this->categoryEntityTable}_varchar` URL_KEY ON URL_KEY.`entity_id` = E.`entity_id` 
                AND URL_KEY.`attribute_id` = ? 
        ", [
            $urlKeyAttributeId
        ]);

        /** @var CategoryInfo[] $categories */
        $categories = [];

        foreach ($categoryData as $categoryDatum) {

            $categoryId = $categoryDatum['entity_id'];
            $storeId = (int)$categoryDatum['store_id'];
            $urlKey = (string)$categoryDatum['url_key'];

            if (array_key_exists($categoryId, $categories)) {

                $categories[$categoryId]->urlKeys[$storeId] = $urlKey;

            } else {

                $categories[$categoryId] = new CategoryInfo(
                    explode('/', $categoryDatum['path']),
                    [$storeId => $urlKey]
                );

            }
        }

        return $categories;
    }

    /**
     * @param int $categoryId
     * @param int[] $idPath The ids of the parent categories, including $categoryId
     * @param array $urlKeys A store-id => url_key array
     */
    public function addCategoryInfo(int $categoryId, array $idPath, array $urlKeys)
    {
        $this->allCategoryInfo[$categoryId] = new CategoryInfo($idPath, $urlKeys);
    }

    protected function getLinkInfo()
    {
        $linkTypeIdRelation = $linkTypeIdUpSell = $linkTypeIdCrossSell = $linkTypeIdSuper = null;
        $linkRelationAttributeIdPosition = $linkUpSellAttributeIdPosition = $linkCrossSellAttributeIdPosition = null;
        $linkSuperAttributeIdPosition = $linkSuperAttributeIdDefaultQuantity = null;

        $rows = $this->db->fetchAllAssoc("
            SELECT `code`, `link_type_id`
            FROM `{$this->linkTypeTable}`
        ");

        foreach ($rows as $row) {
            switch ($row['code']) {
                case 'relation':
                    $linkTypeIdRelation = $row['link_type_id'];
                    break;
                case 'up_sell':
                    $linkTypeIdUpSell = $row['link_type_id'];
                    break;
                case 'cross_sell':
                    $linkTypeIdCrossSell = $row['link_type_id'];
                    break;
                case 'super':
                    $linkTypeIdSuper = $row['link_type_id'];
                    break;
            }
        }

        $rows = $this->db->fetchAllAssoc("
            SELECT `product_link_attribute_id`, `link_type_id`, `product_link_attribute_code`
            FROM `{$this->linkAttributeTable}`
        ");

        foreach ($rows as $row) {
            switch ($row['product_link_attribute_code']) {
                case 'position':
                    switch ($row['link_type_id']) {
                        case $linkTypeIdRelation:
                            $linkRelationAttributeIdPosition = $row['product_link_attribute_id'];
                            break;
                        case $linkTypeIdUpSell:
                            $linkUpSellAttributeIdPosition = $row['product_link_attribute_id'];
                            break;
                        case $linkTypeIdCrossSell:
                            $linkCrossSellAttributeIdPosition = $row['product_link_attribute_id'];
                            break;
                        case $linkTypeIdSuper:
                            $linkSuperAttributeIdPosition = $row['product_link_attribute_id'];
                            break;
                    }
                    break;
                case 'qty':
                    switch ($row['link_type_id']) {
                        case $linkTypeIdSuper:
                            $linkSuperAttributeIdDefaultQuantity = $row['product_link_attribute_id'];
                            break;
                    }

            }
        }

        return [
            LinkInfo::RELATED => new LinkInfo($linkTypeIdRelation, $linkRelationAttributeIdPosition),
            LinkInfo::UP_SELL => new LinkInfo($linkTypeIdUpSell, $linkUpSellAttributeIdPosition),
            LinkInfo::CROSS_SELL => new LinkInfo($linkTypeIdCrossSell, $linkCrossSellAttributeIdPosition),
            LinkInfo::SUPER => new LinkInfo($linkTypeIdSuper, $linkSuperAttributeIdPosition, $linkSuperAttributeIdDefaultQuantity)
        ];
    }
}