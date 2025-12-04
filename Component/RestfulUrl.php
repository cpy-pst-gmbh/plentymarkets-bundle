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

    public const FULFILMENT_PICKLIST = 'fulfillment/picklist/%d';

    public const ITEMS = 'items';
    public const ITEM = 'items/%d';
    public const ITEM_BARCODES = 'items/barcodes';
    public const ITEM_MANUFACTURERS = 'items/manufacturers';
    public const ITEM_SALES_PRICE = 'items/sales_prices/%d';
    public const ITEM_SHIPPING_PROFILES = 'items/%d/item_shipping_profiles';
    public const ITEM_VARIATION = 'items/%d/variations/%d';
    public const ITEM_VARIATION_BARCODES = 'items/%d/variations/%d/variation_barcodes';
    public const ITEM_VARIATION_BOOK_INCOMING_ITEMS = 'items/%d/variations/%d/stock/bookIncomingItems';
    public const ITEM_VARIATION_DESCRIPTIONS = 'items/%d/variations/%d/descriptions';
    public const ITEM_VARIATION_IMAGES = 'items/%d/variations/%d/images';
    public const ITEM_VARIATION_SALES_PRICES = 'items/%d/variations/%d/variation_sales_prices';
    public const ITEM_VARIATION_STOCK = 'items/%d/variations/%d/stock';
    public const ITEM_VARIATION_STOCK_CORRECTION = 'items/%d/variations/%d/stock/correction';
    public const ITEM_VARIATION_STOCK_STORAGE_LOCATIONS = 'items/%d/variations/%d/stock/storageLocations';
    public const ITEM_VARIATION_SUPPLIERS = 'items/%d/variations/%d/variation_suppliers';
    public const ITEM_VARIATION_WAREHOUSES = 'items/%d/variations/%d/variation_warehouses';
    public const ITEM_VARIATION_WAREHOUSES_WAREHOUSE = 'items/%d/variations/%d/variation_warehouses/%d';
    public const ITEM_VARIATIONS = 'items/variations';

    public const ORDER = 'orders/%d';
    public const ORDER_DATE_TYPES = 'orders/dates/types';
    public const ORDER_ITEM = 'orders/%d/items/%d';
    public const ORDER_PROPERTY = 'orders/%d/properties/%d';
    public const ORDER_PROPERTY_TYPE = 'orders/properties/types/%d';
    public const ORDER_REFERRERS = 'orders/referrers';
    public const ORDER_SHIPPING_PACKAGES = 'orders/%d/shipping/packages';
    public const ORDER_SHIPPING_PRESETS = 'orders/shipping/presets';
    public const ORDER_STATUS_HISTORY = 'orders/%d/status-history';
    public const ORDERS = 'orders';


    public const PAYMENTS_METHODS = 'payments/methods';

    public const PROPERTIES = '/rest/properties';
    public const PROPERTIES_RELATIONS = '/rest/properties/relations';
    public const PROPERTIES_RELATIONS_VALUES = '/rest/properties/relations/values';
    public const PROPERTIES_RELATIONS_VALUES_BY_ID = '/rest/properties/relations/values/%d';

    public const STOCK_MANAGEMENT_WAREHOUSE = 'stockmanagement/warehouses/%d';
    public const STOCK_MANAGEMENT_WAREHOUSE_STOCK_MOVEMENTS = 'stockmanagement/warehouses/%d/stock/movements';
    public const STOCK_MANAGEMENT_WAREHOUSES = 'stockmanagement/warehouses';

    public const TAGS_RELATIONSHIPS = 'tags/relationships';

    public const WAREHOUSES_LOCATIONS = 'warehouses/%d/locations';
    public const WAREHOUSES_LOCATIONS_DIMENSIONS = 'warehouses/%d/locations/dimensions';
    public const WAREHOUSES_LOCATIONS_LEVELS = 'warehouses/%d/locations/levels';
    public const WAREHOUSES_LOCATIONS_LOCATION = 'warehouses/locations/%d';
    public const WAREHOUSES_LOCATIONS_STOCK = 'warehouses/locations/stock/%d';

}
