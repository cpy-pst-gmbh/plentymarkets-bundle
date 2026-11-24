<?php

namespace PM\PlentyMarketsBundle\Component;


class RestfulUrl
{
    public const LOGIN = 'login';
    public const BATCH = 'batch';

    public const CATEGORIES = 'categories';

    public const COMMENTS = 'comments';

    public const ACCOUNT_CONTACT = 'accounts/contacts/%d';
    public const ACCOUNT_CONTACTS = 'accounts/contacts';

    public const BACKEND_USERS = 'backend/users';
    public const LOGS = 'logs';
    public const DELETE_LOG = 'delete_log';

    public const FULFILMENT_PICKLIST = 'fulfillment/picklist/%d';

    public const ITEMS = 'items';
    public const ITEM = 'items/%d';
    public const ITEM_UNITS = 'items/units';
    public const ITEM_IMAGE = 'items/%d/images/%d';
    public const ITEM_IMAGE_UPLOAD = 'items/%d/images/upload';
    public const ITEM_BARCODES = 'items/barcodes';
    public const ITEM_MANUFACTURERS = 'items/manufacturers';
    public const ITEM_SALES_PRICE = 'items/sales_prices/%d';
    public const ITEM_SHIPPING_PROFILES = 'items/%d/item_shipping_profiles';
    public const ITEM_VARIATION = 'items/%d/variations/%d';
    public const ITEM_VARIATION_BARCODES = 'items/%d/variations/%d/variation_barcodes';
    public const ITEM_VARIATION_BOOK_INCOMING_ITEMS = 'items/%d/variations/%d/stock/bookIncomingItems';
    public const ITEM_VARIATION_CATEGORIES = 'items/%d/variations/%d/variation_categories';
    public const ITEM_VARIATION_CATEGORY = 'items/%d/variations/%d/variation_categories/%d';
    public const ITEM_VARIATION_DESCRIPTIONS = 'items/%d/variations/%d/descriptions';
    public const ITEM_VARIATION_DESCRIPTION = 'items/%d/variations/%d/descriptions/%s';
    public const ITEM_VARIATION_IMAGES = 'items/%d/variations/%d/images';
    public const ITEM_VARIATION_IMAGE_LINKS = 'items/%d/variations/%d/variation_images';
    public const ITEM_VARIATION_MARKETS = 'items/%d/variations/%d/variation_markets';
    public const ITEM_VARIATION_MARKET = 'items/%d/variations/%d/variation_markets/%s';
    public const ITEM_VARIATION_SALES_PRICES = 'items/%d/variations/%d/variation_sales_prices';
    public const ITEM_VARIATION_SALES_PRICE = 'items/%d/variations/%d/variation_sales_prices/%d';
    public const ITEM_VARIATION_STOCK = 'items/%d/variations/%d/stock';
    public const ITEM_VARIATION_STOCK_CORRECTION = 'items/%d/variations/%d/stock/correction';
    public const ITEM_VARIATION_STOCK_STORAGE_LOCATIONS = 'items/%d/variations/%d/stock/storageLocations';
    public const ITEM_VARIATION_SUPPLIERS = 'items/%d/variations/%d/variation_suppliers';
    public const ITEM_VARIATION_SUPPLIER = 'items/%d/variations/%d/variation_suppliers/%d';
    public const ITEM_VARIATION_WAREHOUSES = 'items/%d/variations/%d/variation_warehouses';
    public const ITEM_VARIATION_WAREHOUSES_WAREHOUSE = 'items/%d/variations/%d/variation_warehouses/%d';
    public const ITEM_VARIATIONS = 'items/variations';

    public const LISTING_MARKETS = 'listings/markets';
    public const LISTING_MARKETS_HISTORIES = 'listings/markets/histories';

    public const ORDER = 'orders/%d';
    public const ORDER_DATE_TYPES = 'orders/dates/types';
    public const ORDER_DOCUMENTS_DOWNLOAD = 'orders/%d/documents/downloads/%s';
    public const ORDER_CREDIT_NOTES = 'orders/%d/credit_notes';
    public const ORDER_ITEM = 'orders/%d/items/%d';
    public const ORDER_PROPERTY = 'orders/%d/properties/%d';
    public const ORDER_PROPERTY_TYPE = 'orders/properties/types/%d';
    public const ORDER_REFERRERS = 'orders/referrers';
    public const ORDER_SHIPPING_PACKAGES = 'orders/%d/shipping/packages';
    public const ORDER_SHIPPING_PRESETS = 'orders/shipping/presets';
    public const ORDER_SHIPPING_COUNTRIES = 'orders/shipping/countries';
    public const ORDER_STATUS_HISTORY = 'orders/%d/status-history';
    public const ORDERS = 'orders';


    public const PAYMENTS_METHODS = 'payments/methods';

    public const PROPERTIES = '/rest/properties';
    public const PROPERTIES_RELATIONS = '/rest/properties/relations';
    public const PROPERTIES_RELATION = '/rest/properties/relations/%d';
    public const PROPERTIES_RELATIONS_VALUES = '/rest/properties/relations/values';
    public const PROPERTIES_RELATIONS_VALUES_BY_ID = '/rest/properties/relations/values/%d';
    public const PROPERTIES_SELECTIONS = '/rest/properties/selections';

    public const STOCK_MANAGEMENT_STOCK = 'stockmanagement/stock';
    public const STOCK_MANAGEMENT_WAREHOUSE = 'stockmanagement/warehouses/%d';
    public const STOCK_MANAGEMENT_WAREHOUSE_STOCK_MOVEMENTS = 'stockmanagement/warehouses/%d/stock/movements';
    public const STOCK_MANAGEMENT_WAREHOUSE_STOCK_STORAGE_LOCATIONS = 'stockmanagement/warehouses/%d/stock/storageLocations';
    public const STOCK_MANAGEMENT_WAREHOUSES = 'stockmanagement/warehouses';

    public const TAGS = 'tags';
    public const TAGS_RELATIONSHIPS = 'tags/relationships';
    public const TAGS_RELATIONSHIP_V2 = 'v2/tags/relationships/%d';

    public const WAREHOUSES_LOCATIONS = 'warehouses/%d/locations';
    public const WAREHOUSES_LOCATIONS_DIMENSIONS = 'warehouses/%d/locations/dimensions';
    public const WAREHOUSES_LOCATIONS_LEVELS = 'warehouses/%d/locations/levels';
    public const WAREHOUSES_LOCATIONS_LOCATION = 'warehouses/locations/%d';
    public const WAREHOUSES_LOCATIONS_STOCK = 'warehouses/locations/stock/%d';

}
