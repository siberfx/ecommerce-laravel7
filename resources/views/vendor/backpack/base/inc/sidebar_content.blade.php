<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


@can('list_categories')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('categories') }}'><i class='nav-icon fa fa-question'></i> {{ trans('category.categories') }}</a></li>
@endcan

@can('list_products')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon fa fa-question'></i> {{ trans('product.products') }}</a></li>
@endcan

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('orders') }}'><i class='nav-icon fa fa-question'></i> {{ trans('order.orders') }}</a></li>

@can('list_clients')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('clients') }}'><i class='nav-icon fa fa-question'></i> {{ trans('client.clients') }}</a></li>
@endcan

@can('list_attributes')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes') }}'><i class='nav-icon fa fa-question'></i> {{ trans('attribute.attributes') }}</a></li>
@endcan

@can('list_attribute_sets')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('attributes-sets') }}'><i class='nav-icon fa fa-question'></i> {{ trans('attribute.attribute_sets') }}</a></li>
@endcan

@can('list_currencies')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('currencies') }}'><i class='nav-icon fa fa-question'></i> {{ trans('currency.currencies') }}</a></li>
@endcan

@can('list_carriers')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('carriers') }}'><i class='nav-icon fa fa-truck'></i> {{ trans('carrier.carriers') }}</a></li>
@endcan

@can('list_taxes')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('taxes') }}'><i class='nav-icon fa fa-balance-scale'></i> {{ trans('tax.taxes') }}</a></li>
@endcan

@can('list_order_statuses')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('order-statuses') }}'><i class='nav-icon fa fa-list-ul'></i> {{ trans('order.order_statuses') }}</a></li>
@endcan

@can('list_cart_rules')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cart-rules') }}'><i class='nav-icon fa fa-shopping-cart'></i> {{ trans('cartrule.cart_rules') }}</a></li>
@endcan

@can('list_specific_prices')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('specific-prices') }}'><i class='nav-icon fa fa-money'></i> {{ trans('specificprice.specific_prices') }}</a></li>
@endcan

@can('list_notification_templates')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('notification-templates') }}'><i class='nav-icon fa fa-list'></i> {{ trans('notification_templates.notification_templates') }}</a></li>
@endcan

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>{{ trans('user.users') }}</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
